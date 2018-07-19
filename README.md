# api2pdf.php
PHP code for [Api2Pdf REST API](https://www.api2pdf.com/documentation) 

Api2Pdf.com is a REST API for instantly generating PDF documents from HTML, URLs, Microsoft Office Documents (Word, Excel, PPT), and images. The API also supports merge / concatenation of two or more PDFs. Api2Pdf is a wrapper for popular libraries such as **wkhtmltopdf**, **Headless Chrome**, and **LibreOffice**.

- [Installation](#installation)
- [Resources](#resources)
- [Authorization](#authorization)
- [Usage](#usage)
- [FAQ](https://www.api2pdf.com/faq)


## <a name="installation"></a>Require the code

Create a file in your PHP project called api2pdf.php and copy and paste the code from [here](https://github.com/Api2Pdf/api2pdf.php/blob/master/api2pdf.php).

## <a name="resources"></a>Resources

Resources this API supports:

- [wkhtmltopdf](#wkhtmltopdf)
- [Headless Chrome](#chrome)
- [LibreOffice](#libreoffice)
- [Merge / Concatenate PDFs](#merge)

## <a name="authorization"></a>Authorization

### Acquire API Key

Create an account at [portal.api2pdf.com](https://portal.api2pdf.com/register) to get your API key.
    
## <a name="#usage"></a>Usage

### Initialize the Client

All usage starts by calling the import command and initializing the client by passing your API key as a parameter to the constructor.

    require ('api2pdf.php'); //or wherever you have stored the file
    
    $a2p_client = Api2Pdf('YOUR-API-KEY');

Once you initialize the client, you can make calls like so:

    $api_response = $a2p_client.headless_chrome_from_html('<p>Hello, World</p>');
    echo($api_response->pdf);
    
### Result Format

An object is returned from every API call. If a call is unsuccessful then `success` will show false and the `error` will provide the reason for failure. Additional attributes include the total data usage in, out, and the cost for the API call, typically very small fractions of a penny.

    {
	    'pdf': 'https://link-to-pdf-only-available-for-24-hours',
	    'mbIn': 0.08421039581298828,
	    'mbOut': 0.08830547332763672,
	    'cost': 0.00017251586914062501,
	    'success': true,
	    'error': null,
	    'responseId': '6e46637a-650d-46d5-af0b-3d7831baccbb'
    }
    
### <a name="wkhtmltopdf"></a> wkhtmltopdf

**Convert HTML to PDF**

    $api_response = $a2p_client.wkhtmltopdf_from_html('<p>Hello, World</p>');
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

    $api_response = $a2p_client.wkhtmltopdf_from_html('<p>Hello, World</p>', $inline = true, $filename = 'test.pdf');
    
**Convert HTML to PDF (use keyword arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

    $options = array("orientation"=>"landscape", "pageSize"=>"A4");
    $api_response = $a2p_client.wkhtmltopdf_from_html('<p>Hello, World</p>', $options = $options);

**Convert URL to PDF**

    $api_response = $a2p_client.wkhtmltopdf_from_url('http://www.api2pdf.com');
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

    $api_response = $a2p_client.wkhtmltopdf_from_url('http://www.api2pdf.com', $inline = true, $filename = 'test.pdf');
    
**Convert URL to PDF (use keyword arguments for advanced wkhtmltopdf settings)**
[View full list of wkhtmltopdf options available.](https://www.api2pdf.com/documentation/advanced-options-wkhtmltopdf/)

    $options = array("orientation"=>"landscape", "pageSize"=>"A4");
    $api_response = $a2p_client.wkhtmltopdf_from_url('http://www.api2pdf.com', $options = $options);


---

## <a name="chrome"></a>Headless Chrome

**Convert HTML to PDF**

    $api_response = $a2p_client.headless_chrome_from_html('<p>Hello, World</p>');
    
**Convert HTML to PDF (load PDF in browser window and specify a file name)**

    $api_response = $a2p_client.headless_chrome_from_html('<p>Hello, World</p>', $inline = true, $filename = 'test.pdf');
    
**Convert HTML to PDF (use keyword arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

    $options = array("landscape"=>true, "printBackground"=>false);
    $api_response = $a2p_client.headless_chrome_from_html('<p>Hello, World</p>', $options = $options);

**Convert URL to PDF**

    $api_response = $a2p_client.headless_chrome_from_url('http://www.api2pdf.com');
    
**Convert URL to PDF (load PDF in browser window and specify a file name)**

    $api_response = $a2p_client.headless_chrome_from_url('http://www.api2pdf.com', $inline = true, $filename = 'test.pdf');
    
**Convert URL to PDF (use keyword arguments for advanced Headless Chrome settings)**
[View full list of Headless Chrome options available.](https://www.api2pdf.com/documentation/advanced-options-headless-chrome/)

    $options = array("landscape"=>true, "printBackground"=>false);
    $api_response = a2p_client.headless_chrome_from_url('http://www.api2pdf.com', $options = $options);
    
---

## <a name="libreoffice"></a>LibreOffice

LibreOffice supports the conversion to PDF from the following file formats:

- doc, docx, xls, xlsx, ppt, pptx, gif, jpg, png, bmp, rtf, txt, html

You must provide a url to the file. Our engine will consume the file at that URL and convert it to the PDF.

**Convert Microsoft Office Document or Image to PDF**

    $api_response = $a2p_client.libreoffice_convert('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx');
    
**Convert Microsoft Office Document or Image to PDF (load PDF in browser window and specify a file name)**

    $api_response = $a2p_client.libreoffice_convert('https://www.api2pdf.com/wp-content/themes/api2pdf/assets/samples/sample-word-doc.docx', $inline = true, $filename = 'test.pdf');
    
---
    
## <a name="merge"></a>Merge / Concatenate Two or More PDFs

To use the merge endpoint, supply a list of urls to existing PDFs. The engine will consume all of the PDFs and merge them into a single PDF, in the order in which they were provided in the list.

**Merge PDFs from list of URLs to existing PDFs**

    $links_to_pdfs = array('https://LINK-TO-PDF', 'https://LINK-TO-PDF');
    $merge_result = $a2p_client.merge(links_to_pdfs)

**Merge PDFs from list of URLs to existing PDFs (load PDF in browser window and specify a file name)**

    $links_to_pdfs = array('https://LINK-TO-PDF', 'https://LINK-TO-PDF');
    $merge_result = $a2p_client.merge(links_to_pdfs, $inline = true, $filename = 'test.pdf');
    
