import fitz  # PyMuPDF
import xlwings as xw
import os
import sys
import shutil

def incrustr_imagen(path_pdf,dat):
    #copiar archivo temporalemete
    origen = path_pdf # Ruta del archivo original
    destino = "temporal/salida_temp.pdf"  # Ruta donde se copiará

    shutil.copy(origen, destino)  # Copia el archivo
    print("Archivo copiado exitosamente.")

    # Archivo PDF existente
    pdf_path = "temporal/salida_temp.pdf"
    # Ruta de la imagen
    image_path = "imagenes_guardadas/firma.png"
    # Nuevo archivo PDF con la imagen
    output_path = path_pdf #"prueba_pdf/pdf_con_imagen.pdf"

    # Abrir el PDF
    pdf_document = fitz.open(pdf_path)

    # Elegir la página donde insertar la imagen (por ejemplo, la primera)
    pagina = pdf_document[0]

    # Definir la posición y tamaño de la imagen
    if dat == "0":
        rect = fitz.Rect(77, 210, 150, 1000)  # (x1, y1, x2, y2)
    else:
        rect = fitz.Rect(77, 415, 150, 1000)

    # Insertar la imagen en la página
    pagina.insert_image(rect, filename=image_path)

    # Guardar el nuevo archivo PDF
    pdf_document.save(output_path,garbage=4)
    pdf_document.close()

    print(f"PDF guardado con éxito en: {output_path}")

    archivo_temporal = "temporal/salida_temp.pdf"

    if os.path.exists(archivo_temporal):  # Verifica si el archivo existe
        os.remove(archivo_temporal)
        print("Archivo eliminado exitosamente.")
    else:
        print("El archivo no existe.")



if len(sys.argv) > 0:
    ruta_pdf = sys.argv[1] #r"C:\xampp\htdocs\firma_acr\imagenes_guardadas\salida.pdf"
    dato = sys.argv[2]
    print(f"Recibido: {ruta_pdf}{dato}")
    incrustr_imagen(ruta_pdf,dato)
else:
    print("No se recibieron parámetros")



