<?php

namespace Api2Pdf;

use Api2Pdf\Exception\ConversionException;
use Api2Pdf\Exception\ProtocolException;

interface Api2PdfInterface
{
    /**
     * @param string $url
     *
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromUrl($url, $filename = null, $inline = false, $options = null);

    /**
     * @param string $html
     *
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function headlessChromeFromHtml($html, $filename = null, $inline = false, $options = null);

    /**
     * @param string $url
     *
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     */
    public function wkHtmlToPdfFromUrl($url, $filename = null, $inline = false, $options = null);

    /**
     * @param string $html
     *
     * @param null $filename
     * @param bool $inline
     * @param array $options
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function wkHtmlToPdfFromHtml($html, $filename = null, $inline = false, $options = null);

    /**
     * @param array $urls
     *
     * @param null $filename
     * @param bool $inline
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function merge(array $urls, $filename = null, $inline = false);

    /**
     * @param string $url
     *
     * @param null $filename
     * @param bool $inline
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function libreOfficeConvert($url, $filename = null, $inline = false);

    /**
     * @param string $responseId
     *
     * @return ApiResult
     * @throws ConversionException
     * @throws ProtocolException
     */
    public function delete($responseId);
}