# api2pdf.php
PHP code for [Api2Pdf REST API](https://www.api2pdf.com/documentation/v2) 

Api2Pdf.com is a powerful REST API for instantly generating PDF and Office documents from HTML, URLs, Microsoft Office Documents (Word, Excel, PPT), Email files, and images. You can generate image preview or thumbnail of a PDF, office document, or email file. The API also supports merge / concatenation of two or more PDFs, setting passwords on PDFs, and adding bookmarks to PDFs. Api2Pdf is a wrapper for popular libraries such as **wkhtmltopdf**, **Headless Chrome**, **PdfSharp**, and **LibreOffice**.

- [Installation](#installation)
- [Resources](#resources)
- [Authorization](#authorization)
- [Usage](#usage)
- [FAQ](https://www.api2pdf.com/faq)

## <a name="installation"></a>Installation

Run the following from command line:

```
$ composer require api2pdf/api2pdf.php
```

## Usage without Composer

Copy the file in the `src` directory to a sub-directory in your project, then add the following in the beginning of your PHP file:

```
require_once 'your-own-directory/Api2Pdf.php';

```

## <a name="resources"></a>Resources

Resources this API supports:

- [wkhtmltopdf](#wkhtmltopdf)
- [Headless Chrome](#chrome)
- [LibreOffice](#libreoffice)
- [Merge / Concatenate PDFs](#merge)
- [Helper Methods](#helper-methods)

## <a name="authorization"></a>Authorization

### Acquire API Key

Create an account at [portal.api2pdf.com](https://portal.api2pdf.com/register) to get your API key.
    
## <a name="#usage"></a>Usage

### Initialize the Client

All usage starts by calling the import command and initializing the client by passing your API key as a parameter to the constructor.

```php
use Api2Pdf\Api2Pdf;

$apiClient = new Api2Pdf('YOUR-API-KEY');
```

Once you initialize the client, you can make calls like so:

```php
$result = $apiClient->chromeHtmlToPdf('<p>Hello, World</p>');
echo $result->getFile();
```
    
### Result Format

An ApiResult object is returned from every API call. If a call is unsuccessful then an exception will be thrown with a message containing the result of failure. 

Additional attributes include the total data usage out, and the cost for the API call, typically very small fractions of a penny.

```php
$file = $result->getFile();
$cost = $result->getCost();
$mbOut = $result->getMbOut();
$seconds = $result->getSeconds();
$responseId = $result->getResponseId();
```
    
### <a name="wkhtmltopdf"></a> wkhtmltopdf

**Convert HTML to PDF**

```php
$result = $apiClient->wkHtmlToPdf('<p>Hello, World</p>');
```
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

```php
$result = $apiClient->wkHtmlToPdf('<p>Hello, World</p>', $inline = false, $fileName = "test.pdf");
```
    
**Convert HTML to PDF (use arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

```php
$options = [
    "orientation" => "landscape",
    "pageSize" => "A4"
];
$result = $apiClient->wkHtmlToPdf('<p>Hello, World</p>', $inline = false, $filename = "test.pdf", $options = $options);
```

**Convert URL to PDF**

```php
$result = $apiClient->wkUrlToPdf('http://www.api2pdf.com');
```
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

```php
$result = $apiClient->wkUrlToPdf('http://www.api2pdf.com', $inline = false, $fileName = "test.pdf");
```
    
**Convert URL to PDF (use arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

```php
$options = [
    "orientation" => "landscape",
    "pageSize" => "A4"
];
$result = $apiClient->wkUrlToPdf('http://www.api2pdf.com', $inline = false, $filename = "test.pdf", $options = $options);
```


---

## <a name="chrome"></a>Headless Chrome

**Convert HTML to PDF**

```php
$result = $apiClient->chromeHtmlToPdf('<p>Hello, World</p>');
```
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

```php
$result = $apiClient->chromeHtmlToPdf('<p>Hello, World</p>', $inline = false, $filename = "test.pdf");
```
    
**Convert HTML to PDF (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

```php
$options = [
    "landscape" => true
];
$result = $apiClient->chromeHtmlToPdf('<p>Hello, World</p>', $inline = false, $filename = "test.pdf", $options = $options);
```

**Convert URL to PDF**

```php
$result = $apiClient->chromeUrlToPdf('http://www.api2pdf.com');
```
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

```php
$result = $apiClient->chromeUrlToPdf('http://www.api2pdf.com', $inline = false, $filename = "test.pdf");
```
    
**Convert URL to PDF (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

```php
$options = [
    "landscape" => true
];
$result = $apiClient->chromeUrlToPdf('http://www.api2pdf.com', $inline = false, $filename = "test.pdf", $options = $options);
```

**Convert HTML to Image**

```php
$result = $apiClient->chromeHtmlToImage('<p>Hello, World</p>');
```
    
**Convert HTML to Image (load image in browser window and specify a file name)**

```php
$result = $apiClient->chromeHtmlToImage('<p>Hello, World</p>', $inline = false, $filename = "test.jpg");
```
    
**Convert HTML to Image (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

```php
$options = [
    "fullPage" => true
];
$result = $apiClient->chromeHtmlToImage('<p>Hello, World</p>', $inline = false, $filename = "test.jpg", $options = $options);
```

**Convert URL to Image**

```php
$result = $apiClient->chromeUrlToImage('http://www.api2pdf.com');
```
    
**Convert URL to Image (load image in browser window and specify a file name)**

```php
$result = $apiClient->chromeUrlToImage('http://www.api2pdf.com', $inline = false, $filename = "test.jpg");
```
    
**Convert URL to Image (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

```php
$options = [
    "fullPage" => true
];
$result = $apiClient->chromeUrlToImage('http://www.api2pdf.com', $inline = false, $filename = "test.jpg", $options = $options);
```
    
---

## <a name="libreoffice"></a>LibreOffice

Convert any office file to PDF, image file to PDF, email file to PDF, HTML to Word, HTML to Excel, and PDF to HTML. Any file that can be reasonably opened by LibreOffice should be convertible. Additionally, we have an endpoint for generating a *thumbnail* of the first page of your PDF or Office Document. This is great for generating an image preview of your files to users.

You must provide a url to the file. Our engine will consume the file at that URL and convert it to the PDF.

**Convert Microsoft Office Document or Image to PDF**

```php
$result = $apiClient->libreOfficeAnyToPdf('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx');
```

**Thumbnail or Image Preview of a PDF or Office Document or Email file**

```php
$result = $apiClient->libreOfficeThumbnail('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx');
```

**Convert HTML to Microsoft Word or Docx**

```php
$result = $apiClient->libreOfficeHtmlToDocx('http://www.api2pdf.com/wp-content/uploads/2021/01/sampleHtml.html');
```

**Convert HTML to Microsoft Excel or Xlsx**

```php
$result = $apiClient->libreOfficeHtmlToXlsx('http://www.api2pdf.com/wp-content/uploads/2021/01/sampleTables.html');
```

**Convert PDF to HTML**

```php
$result = $apiClient->libreOfficePdfToHtml('http://www.api2pdf.com/wp-content/uploads/2021/01/1a082b03-2bd6-4703-989d-0443a88e3b0f-4.pdf');
```
---
    
## <a name="merge"></a>PdfSharp - Merge / Concatenate Two or More PDFs, Add bookmarks to pdfs, add passwords to pdfs

To use the merge endpoint, supply a list of urls to existing PDFs. The engine will consume all of the PDFs and merge them into a single PDF, in the order in which they were provided in the list.

**Merge PDFs from list of URLs to existing PDFs**

```php
$linksToPdfs = ['https://LINK-TO-PDF', 'https://LINK-TO-PDF'];
$mergeResult = $apiClient->pdfsharpMerge($linksToPdfs);
```

**Add bookmarks to existing PDF**

```php
$linkToPdf = 'https://LINK-TO-PDF';
$bookmarks = [
    [ "Page" => 0, "Title" => "Introduction" ],
    [ "Page" => 1, "Title" => "Second page" ] 
];
$bookmarkResult = $apiClient->pdfsharpAddBookmarks($linkToPdf, $bookmarks);
```

**Add password to existing PDF**

```php
$linkToPdf = 'https://LINK-TO-PDF';
$userpassword = 'hello';
$bookmarkResult = $apiClient->pdfsharpAddPassword($linkToPdf, $userpassword);
```
    
---

## <a name="helper-methods"></a>Helper Methods

**delete($responseId)**

By default, Api2Pdf will delete your generated file 24 hours after it has been generated. For those with high security needs, you may want to delete your file on command. You can do so by making an DELETE api call with the `responseId` attribute that was returned on the original JSON payload.

```php
$result = $apiClient->chromeHtmlToPdf("<p>Hello World</p>");
$responseId = $result->getResponseId();
//delete pdf
$apiClient->utilityDelete($responseId);
```
