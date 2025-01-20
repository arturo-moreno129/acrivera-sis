import xlwings as xw
import os
import sys

def convertir_excel_a_pdf(ruta_excel, ruta_pdf):
    # Verificar si el archivo Excel existe
    if not os.path.exists(ruta_excel):
        print(f"El archivo Excel '{ruta_excel}' no existe.")
        return
        

    try:
        # Abrir Excel y el archivo
        app = xw.App(visible=False)
        libro = app.books.open(ruta_excel)

        # Guardar como PDF
        libro.to_pdf(ruta_pdf)

        # Cerrar el libro y la aplicación
        libro.close()
        app.quit()

        print(f"Archivo PDF generado exitosamente: {ruta_pdf}")

    except Exception as e:
        print(f"Error al convertir el archivo: {e}")

if len(sys.argv) > 1:
    ruta_excel = sys.argv[1]  #r"C:\xampp\htdocs\firma_acr\imagenes_guardadas\archivo_con_firma.xlsx"
    ruta_pdf = sys.argv[2] #r"C:\xampp\htdocs\firma_acr\imagenes_guardadas\salida.pdf"
    print(f"Recibido: {ruta_excel}{ruta_pdf}")
    convertir_excel_a_pdf(ruta_excel, ruta_pdf)
else:
    print("No se recibieron parámetros")
# Ruta del archivo Excel y el destino del PDF






