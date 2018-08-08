<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 12:09
 */

namespace App\Utils\Generic;


use App\Exception\FileException;
use App\Exception\FileNotFoundException;
use App\Exception\FileOpenException;

class FileServicesGeneric
{

    /**
     * @param string $fileName
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function getContentFile( string $fileName ): string
    {
        $filePath = $this -> getDataFilePath( $fileName );

        try {
            return $this -> readFile( $filePath );
        } catch( \Exception $e ) {
            throw $e;
        }
    }


    /**
     * @param string $fileName
     *
     * @return string
     */
    private function getDataFilePath( string $fileName ): string {


        return __DIR__."/../../../data/".$fileName;

    }


    /**
     * @param $filePath
     *
     * @return string
     *
     * @throws FileNotFoundException
     * @throws FileException
     */
    private function readFile( $filePath ): string {

        try {

            $this -> isFileExist( $filePath );

            return $this -> readWithStandardFunction( $filePath );

        } catch( FileNotFoundException $e ) {
           throw $e;
        } catch( \Exception $e ) {
            throw new FileException("Error when opening file ".$e -> getMessage());
        }

    }


    /**
     * @param $filePath
     *
     * @return string
     */
    private function readWithStandardFunction( $filePath ): string {
        return file_get_contents( $filePath );
    }


    /**
     * @param $filePath
     *
     * @return string
     *
     * @throws FileOpenException
     */
    private function readWithFp( $filePath ): string {

        $contentRetour = "";

        $fp = fopen($filePath,"r");

        if( !is_resource($fp) ) {
            throw new FileOpenException("Error when openfile file with fopen");
        }

        while( $line = fread($fp,1024) ) {
            $contentRetour .= $line;
        }

        fclose( $fp );

        return $contentRetour;
    }


    /**
     * @param string $filepath
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    private function isFileExist( string $filepath ): bool {

        if( !file_exists($filepath) ) {
            throw new FileNotFoundException("The file ".$filepath." isn't exist");
        }

        return true;
    }
}