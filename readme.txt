<td style="text-align: center;">' .
                                    ($row["id_usuario"] == 2 ?
                                        '<a href="' . $row["url_resguardo"] . '" target="_blank" style="pointer-events:auto" rel="noopener noreferrer">
               				 <img id="pdf-icon" src="imagenes/pdf_img.png" alt="" style="width: 35px;">
            				</a>' :
                                        '<img id="pdf-icon" src="imagenes/error.png" alt="" style="width: 35px;">') .
                                    '</td>