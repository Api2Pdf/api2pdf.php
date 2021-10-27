<?php

namespace Api2Pdf;

class Api2PdfResult
{
    /**
     * @var string|null
     */
    private $file = null;

    /**
     * @var float|null
     */
    private $seconds = null;

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

    private $raw_json = null;

    public static function createFromResponse($response)
    {
        $data = json_decode($response, true);

        if ($data === false) {
            throw new ProtocolException('Error decoding API response');
        }

        if (!isset($data['Success']) || !$data['Success']) {
            if (isset($data['Error'])) {
                $errorMessage = $data['Error'];
            } else {
                $errorMessage = 'Error response received from API';
            }

            throw new Api2PdfException($errorMessage);
        }

        $apiResponse = new static();

        $apiResponse->file = isset($data['FileUrl'])?$data['FileUrl']: null;
        $apiResponse->seconds = $data['Seconds'];
        $apiResponse->mbOut = $data['MbOut'];
        $apiResponse->cost = $data['Cost'];
        $apiResponse->responseId = $data['ResponseId'];
        $apiResponse->raw_json = $response;

        return $apiResponse;
    }

    /**
     * @return string|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string|null
     */
    public function getFileContents()
    {
        return $this->file ? file_get_contents($this->file) : null;
    }

    public function getJson()
    {
        return $this->raw_json;
    }

    /**
     * @return float|null
     */
    public function getSeconds()
    {
        return $this->seconds;
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
