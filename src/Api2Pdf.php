<?php

namespace Api2Pdf;

use Api2Pdf\Exception\ProtocolException;
use Api2Pdf\Exception\ConversionException;

class Api2Pdf
{
    const API2PDF_API_URL = 'https://v2018.api2pdf.com';

    /**
     * @var string|null
     */
    private $apiKey = null;

    /**
     * @var bool
     */
    private $inline = false;

    /**
     * @var string|null
     */
    private $filename = null;

    /**
     * @var array
     */
    private $options = [];

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * @return bool
     */
    public function isInline()
    {
        return $this->inline;
    }

    /**
     * @param bool $inline
     *
     * @return Api2Pdf
     */
    public function setInline($inline)
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     *
     * @return Api2Pdf
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Api2Pdf
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param $endpoint
     * @param $payload
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws Exception\ProtocolException
     */
    private function makeRequest($endpoint, $payload) {
        $url = self::API2PDF_API_URL . $endpoint;

        $ch = curl_init($url);

        $jsonDataEncoded =  json_encode($payload);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: '.$this->apiKey
            ]
        );

        $response = curl_exec($ch);

        if ($response === false) {
            throw new ProtocolException(curl_error($ch) ?: 'API request failed');
        }

        return ApiResult::createFromResponse($response);
    }

    /**
     * @param bool $withOptions
     *
     * @return array
     */
    private function buildPayloadBase($withOptions = true)
    {
        $payload = [
            'inlinePdf' => $this->inline,
        ];

        if (!is_null($this->filename)) {
            $payload["fileName"] = $this->filename;
        }

        if ($withOptions && !empty($this->options)) {
            $payload["options"] = $this->options;
        }

        return $payload;
    }

    /**
     * @param string $url
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromUrl($url) {
        $payload = array_merge(
            $this->buildPayloadBase(),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/chrome/url', $payload);
    }

    /**
     * @param string $html
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromHtml($html) {
        $payload = array_merge(
            $this->buildPayloadBase(),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/chrome/html', $payload);
    }

    /**
     * @param string $url
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function wkHtmlToPdfFromUrl($url) {
        $payload = array_merge(
            $this->buildPayloadBase(),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/wkhtmltopdf/url', $payload);
    }

    /**
     * @param string $html
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function wkHtmlToPdfFromHtml($html) {
        $payload = array_merge(
            $this->buildPayloadBase(),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/wkhtmltopdf/html', $payload);
    }

    /**
     * @param array $urls
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function merge(array $urls) {
        $payload = array_merge(
            $this->buildPayloadBase(false),
            [
                'urls' => $urls,
            ]
        );

        return $this->makeRequest('/merge', $payload);
    }

    /**
     * @param string $url
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function libreOfficeConvert($url) {
        $payload = array_merge(
            $this->buildPayloadBase(false),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/convert', $payload);
    }

}