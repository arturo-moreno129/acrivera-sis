
import fitz  # PyMuPDF

# Archivo PDF existente
pdf_path = "prueba_pdf/salida.pdf"
# Ruta de la imagen
image_path = "prueba_pdf/firma.png"
# Nuevo archivo PDF con la imagen
output_path = "prueba_pdf/pdf_con_imagen.pdf"

# Abrir el PDF
pdf_document = fitz.open(pdf_path)

# Elegir la página donde insertar la imagen (por ejemplo, la primera)
pagina = pdf_document[0]

# Definir la posición y tamaño de la imagen
rect = fitz.Rect(77, 400, 150, 1000)  # (x1, y1, x2, y2)

# Insertar la imagen en la página
pagina.insert_image(rect, filename=image_path)

# Guardar el nuevo archivo PDF
pdf_document.save(output_path)
pdf_document.close()

print(f"PDF guardado con éxito en: {output_path}")
