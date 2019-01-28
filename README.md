# api2pdf.php
PHP code for [Api2Pdf REST API](https://www.api2pdf.com/documentation) 

Api2Pdf.com is a REST API for instantly generating PDF documents from HTML, URLs, Microsoft Office Documents (Word, Excel, PPT), and images. The API also supports merge / concatenation of two or more PDFs. Api2Pdf is a wrapper for popular libraries such as **wkhtmltopdf**, **Headless Chrome**, and **LibreOffice**.

- [Installation](#installation)
- [Resources](#resources)
- [Authorization](#authorization)
- [Usage](#usage)
- [FAQ](https://www.api2pdf.com/faq)

## <a name="installation"></a>Installation

Add this repository to your Composer file:

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/api2pdf/api2pdf.php"
        }
    ],
```

Run the following from command line:

``$ composer require api2pdf/api2pdf.php:dev-master``

## Usage without Composer

Copy the files in the `src` directory to a sub-directory in your project, then add the following in the beginning of your PHP file:

```
require_once 'your-own-directory/Api2Pdf.php';
require_once 'your-own-directory/ApiResult.php';

use Api2Pdf\Api2Pdf;
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

    $apiClient = new Api2Pdf('YOUR-API-KEY')

Once you initialize the client, you can make calls like so:

    $result = $apiClient->headlessChromeFromHtml('<p>Hello, World</p>');
    echo $result->getPdf();
    
### Result Format

An ApiResult object is returned from every API call. If a call is unsuccessful then an exception will be thrown with a message containing the result of failure. 

Additional attributes include the total data usage in, out, and the cost for the API call, typically very small fractions of a penny.

    $pdfLink = $result->getPdf();
    $mbIn = $result->getMbIn();
    $mbOut = $result->getMbOut();
    $cost = $result->getCost();
    $responseId = $result->getResponseId();
    
### <a name="wkhtmltopdf"></a> wkhtmltopdf

**Convert HTML to PDF**

    $result = $apiClient->wkHtmlToPdfFromHtml('<p>Hello, World</p>');
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $result = $apiClient->wkHtmlToPdfFromHtml('<p>Hello, World</p>');
    
**Convert HTML to PDF (use arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $apiClient->setOptions(
        [
            'orientation' => 'landscape', 
            'pageSize'=> 'A4'
        ]
    );
    $result = $apiClient->wkHtmlToPdfFromHtml('<p>Hello, World</p>');

**Convert URL to PDF**

    $result = $apiClient->wkHtmlToPdfFromUrl('http://www.api2pdf.com');
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $result = $apiClient->wkHtmlToPdfFromUrl('http://www.api2pdf.com');
    
**Convert URL to PDF (use arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $apiClient->setOptions(
        [
            'orientation' => 'landscape', 
            'pageSize'=> 'A4'
        ]
    );
    $result = $apiClient->wkHtmlToPdfFromUrl('http://www.api2pdf.com');


---

## <a name="chrome"></a>Headless Chrome

**Convert HTML to PDF**

    $result = $apiClient->headlessChromeFromHtml('<p>Hello, World</p>');
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $result = $apiClient->headlessChromeFromHtml('<p>Hello, World</p>');
    
**Convert HTML to PDF (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $apiClient->setOptions(
        [
            'landscape' => true, 
            'printBackground' => false
        ]
    );        
    $result = $apiClient->headlessChromeFromHtml('<p>Hello, World</p>');

**Convert URL to PDF**

    $result = $apiClient->headlessChromeFromUrl('http://www.api2pdf.com');
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $result = $apiClient->headlessChromeFromUrl('http://www.api2pdf.com');
    
**Convert URL to PDF (use arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $apiClient->setOptions(
        [
            'landscape' => true, 
            'printBackground' => false
        ]
    );        
    $result = $apiClient->headlessChromeFromUrl('http://www.api2pdf.com');
    
---

## <a name="libreoffice"></a>LibreOffice

LibreOffice supports the conversion to PDF from the following file formats:

- doc / docx
- xls / xlsx
- ppt / pptx
- gif
- jpg
- png
- bmp
- rtf
- txt 
- html

You must provide a URL to the file. Our engine will consume the file at that URL and convert it to the PDF.

**Convert Microsoft Office Document or Image to PDF**

    $result = $apiClient->libreOfficeConvert('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx');
    
**Convert Microsoft Office Document or Image to PDF (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $result = $apiClient->libreOfficeConvert('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx');
    
---
    
## <a name="merge"></a>Merge / Concatenate Two or More PDFs

To use the merge endpoint, supply a list of URLs to existing PDFs. The engine will consume all of the PDFs and merge them into a single PDF, in the order in which they were provided in the list.

**Merge PDFs from list of URLs to existing PDFs**

    $linksToPdfs = ['https://LINK-TO-PDF', 'https://LINK-TO-PDF'];
    $mergeResult = $apiClient->merge($linksToPdfs)

**Merge PDFs from list of URLs to existing PDFs (load PDF in browser window and specify a file name)**

    $apiClient->setInline(true);
    $apiClient->setFilename('test.pdf');
    $linksToPdfs = ['https://LINK-TO-PDF', 'https://LINK-TO-PDF'];
    $mergeResult = $apiClient->merge($linksToPdfs)
    
---

## <a name="helper-methods"></a>Helper Methods

**delete($responseId)**

By default, Api2Pdf deletes your PDFs 24 hours after they have been generated. For developers who require higher levels of security and wish to delete their PDFs can make a DELETE request API call by using the `responseId` retrieved from the original request.

    $result = $apiClient->headlessChromeFromHtml("<p>Hello World</p>");
    $responseId = $result->getResponseId();
    //delete pdf
    $apiClient->delete($responseId);

    
