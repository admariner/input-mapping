<?php

namespace Keboola\InputMapping\File\Strategy;

use Keboola\InputMapping\File\StrategyInterface;
use Keboola\StorageApi\Workspaces;

class ABSWorkspace extends AbstractStrategy implements StrategyInterface
{
    protected $inputs = [];

    public function downloadFile($fileInfo, $destinationPath)
    {
        $this->inputs[] = [
            'dataFileId' => $fileInfo['id'],
            'destination' => $destinationPath,
        ];
        $this->manifestWriter->writeFileManifest(
            $fileInfo,
            $this->ensurePathDelimiter($this->metadataStorage->getPath()) .
            $destinationPath . '/' . $fileInfo['id'] . '.manifest'
        );
    }

    public function downloadFiles($fileConfigurations, $destination)
    {
        parent::downloadFiles($fileConfigurations, $destination);
        if ($this->inputs) {
            $workspaces = new Workspaces($this->clientWrapper->getBasicClient());
            $workspaceId = $this->dataStorage->getWorkspaceId();
            foreach ($this->inputs as $input) {
                var_dump($input);
                $workspaces->loadWorkspaceData($workspaceId, [
                    'input' => [$input],
                    'preserve' => '1',
                ]);
            }
            $this->logger->info('All files were fetched.');
        }
    }

    protected function getFileDestinationPath($destinationPath, $fileId, $fileName)
    {
        /* Contrary to local strategy, in case of ABSWorkspace, the path is always a directory to which a
            file is exported with the name being fileId. */
        return sprintf(
            '%s/%s',
            $this->ensureNoPathDelimiter($destinationPath),
            $fileName
        );
    }
}
