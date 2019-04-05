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
     * @deprecated Use the method argument $options['inline'] instead.
     */
    private $inline = false;

    /**
     * @var string|null
     * @deprecated Use the method argument $options['filename'] instead.
     */
    private $filename = null;

    /**
     * @var array
     * @deprecated Use the method argument $options instead.
     */
    private $options = [];

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function isInline()
    {
        return $this->inline;
    }

    /**
     * @param bool $inline
     *
     * @return Api2Pdf
     *
     * @deprecated Use the method argument $options['inline'] instead.
     */
    public function setInline($inline)
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * @return string|null
     * @deprecated
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     *
     * @return Api2Pdf
     *
     * @deprecated Use the method argument $options['filename'] instead.
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
    private function makeRequest($endpoint, $payload)
    {
        $url = self::API2PDF_API_URL . $endpoint;

        $ch = curl_init($url);

        $jsonDataEncoded = json_encode($payload);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: ' . $this->apiKey
            ]
        );

        $response = curl_exec($ch);

        if ($response === false) {
            throw new ProtocolException(curl_error($ch) ?: 'API request failed');
        }

        return ApiResult::createFromResponse($response);
    }

    /**
     * @param null $filename
     * @param bool $inline
     * @param null $options
     * @return array
     */
    private function buildPayloadBase($filename, $inline, $options = null)
    {
        $payload = [
            'inlinePdf' => $inline
        ];

        if (!is_null($filename)) {
            $payload["fileName"] = $filename;
        }

        if (!empty($options)) {
            $payload["options"] = $options;
        }

        return $payload;
    }

    /**
     * @param $url
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromUrl($url, $filename = null, $inline = false, $options = null)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline, $options),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/chrome/url', $payload);
    }

    /**
     * @param $html
     * @param null $filename
     * @param bool $inline
     * @param null $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromHtml($html, $filename = null, $inline = false, $options = null)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline, $options),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/chrome/html', $payload);
    }

    /**
     * @param $url
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function wkHtmlToPdfFromUrl($url, $filename = null, $inline = false, $options = null)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline, $options),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/wkhtmltopdf/url', $payload);
    }

    /**
     * @param $html
     * @param null $filename
     * @param bool $inline
     * @param null $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function wkHtmlToPdfFromHtml($html, $filename = null, $inline = false, $options = null)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline, $options),
            [
                'html' => $html,
            ]
        );

        return $this->makeRequest('/wkhtmltopdf/html', $payload);
    }

    /**
     * @param array $urls
     * @param null $filename
     * @param bool $inline
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function merge(array $urls, $filename = null, $inline = false)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline, null),
            [
                'urls' => $urls,
            ]
        );

        return $this->makeRequest('/merge', $payload);
    }

    /**
     * @param string $url
     *
     * @param null $filename
     * @param bool $inline
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function libreOfficeConvert($url, $filename = null, $inline = false)
    {
        $payload = array_merge(
            $this->buildPayloadBase($filename, $inline),
            [
                'url' => $url,
            ]
        );

        return $this->makeRequest('/libreoffice/convert', $payload);
    }

    /**
     * @param string $responseId
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function delete($responseId)
    {
        $url = self::API2PDF_API_URL . '/pdf/' . $responseId;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: ' . $this->apiKey
            ]
        );

        $response = curl_exec($ch);

        if ($response === false) {
            throw new ProtocolException(curl_error($ch) ?: 'API request failed');
        }

        return ApiResult::createFromResponse($response);
    }
}