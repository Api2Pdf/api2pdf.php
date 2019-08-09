<?php

namespace Api2Pdf;

use Api2Pdf\Exception\ConversionException;
use Api2Pdf\Exception\ProtocolException;

class ApiResult
{
    /**
     * @var string|null
     */
    private $pdf = null;

    /**
     * @var float|null
     */
    private $mbIn = null;

    /**
     * @var float|null
     */
    private $mbOut = null;

    /**
     * @var float|null
     */
    private $cost = null;

    /**
     * @var string|null
     */
    private $responseId = null;

    public static function createFromResponse($response)
    {
        $data = json_decode($response, true);

        if ($data === false) {
            throw new ProtocolException('Error decoding API response');
        }

        if (!isset($data['success']) || !$data['success']) {
            if (isset($data['error'])) {
                $errorMessage = $data['error'];
            } elseif (isset($data['reason'])) {
                $errorMessage = $data['reason'];
            } else {
                $errorMessage = 'Error response received from API';
            }

            throw new ConversionException($errorMessage);
        }

        $apiResponse = new static();

        $apiResponse->pdf = isset($data['pdf'])?$data['pdf']: null;
        $apiResponse->mbIn = $data['mbIn'];
        $apiResponse->mbOut = $data['mbOut'];
        $apiResponse->cost = $data['cost'];
        $apiResponse->responseId = $data['responseId'];

        return $apiResponse;
    }

    /**
     * @return string|null
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * @return float|null
     */
    public function getMbIn()
    {
        return $this->mbIn;
    }

    /**
     * @return float|null
     */
    public function getMbOut()
    {
        return $this->mbOut;
    }

    /**
     * @return float|null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return string|null
     */
    public function getResponseId()
    {
        return $this->responseId;
    }
}