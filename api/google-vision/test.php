<?php
/**
 * Created by PhpStorm.
 * User: ussaidiqbal
 * Date: 11/9/21
 * Time: 1:55 PM
 */
include "autoload.php";

use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Likelihood;


function CheckImage($path = "test.php"){

    try{
        putenv("GOOGLE_APPLICATION_CREDENTIALS=../../wequestion-indexing-8f5b8584342f.json");


        $imageAnnotator = new ImageAnnotatorClient();

        $image = file_get_contents($path);
        $response = $imageAnnotator->safeSearchDetection($image);
        $safe = $response->getSafeSearchAnnotation();

        $adult = $safe->getAdult();
        $medical = $safe->getMedical();
        /*
            $spoof = $safe->getSpoof();
            $violence = $safe->getViolence();
            $racy = $safe->getRacy();
        */
        # names of likelihood from google.cloud.vision.enums
        $likelihoodName = [
            'UNKNOWN',
            'VERY_UNLIKELY',
            'UNLIKELY',
            'POSSIBLE',
            'LIKELY',
            'VERY_LIKELY'
        ];
        echo "<img src ='".$path."' style='width: auto; max-height: 300px; border-radius: 10px'>";
        echo "<br/>";
        printf('Adult: %s' . PHP_EOL, $likelihoodName[$adult]);
        printf('Medical: %s' . PHP_EOL, $likelihoodName[$medical]);

        $imageAnnotator->close();

    }catch (Exception $exception){
        echo "<pre>";
        print_r($exception);
        echo "</pre>";
    }
}

CheckImage("test-2.jpeg");
echo "<br/>";
CheckImage("test.jpeg");
echo "<br/>";
CheckImage("test-3.jpeg");
echo "<br/>";
CheckImage("test-4.jpeg");
?>