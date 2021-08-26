<?php

namespace Api2Pdf;

interface Api2PdfInterface
{
    public function chromeUrlToPdf($url, $inline = true, $filename = null, $options = null);
    public function chromeHtmlToPdf($html, $inline = true, $filename = null, $options = null);
    public function chromeUrlToImage($url, $inline = true, $filename = null, $options = null);
    public function chromeHtmlToImage($html, $inline = true, $filename = null, $options = null);
    public function wkUrlToPdf($url, $inline = true, $filename = null, $options = null, $enableToc = false);
    public function wkHtmlToPdf($html, $inline = true, $filename = null, $options = null, $enableToc = false);
    public function libreOfficeAnyToPdf($url, $inline = true, $filename = null);
    public function libreOfficeThumbnail($url, $inline = true, $filename = null);
    public function libreOfficePdfToHtml($url, $inline = true, $filename = null);
    public function libreOfficeHtmlToDocx($url, $inline = true, $filename = null);
    public function libreOfficeHtmlToXlsx($url, $inline = true, $filename = null);
    public function pdfsharpMerge($urls, $inline = true, $filename = null);
    public function pdfsharpAddBookmarks($url, $bookmarks, $inline = true, $filename = null);
    public function pdfsharpAddPassword($url, $userpassword, $ownerpassword = null, $inline = true, $filename = null);
    public function utilityDelete($responseId);
}
