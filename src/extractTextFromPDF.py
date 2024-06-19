import fitz  # PyMuPDF

def extract_text_from_first_page(pdf_path):
    # Open the provided PDF file
    document = fitz.open(pdf_path)
    
    # Get text from the first page
    first_page_text = document[0].get_text()
    
    # Close the document
    document.close()
    
    return first_page_text

if __name__ == "__main__":
    import sys
        
    pdf_path = sys.argv[1]
    print('PDF_PATH: ', pdf_path)
    extracted_text = extract_text_from_first_page(pdf_path)
    
    print(extracted_text)
