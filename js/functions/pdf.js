

  function agregarImagenAPDF() {
    // Crea un nuevo documento PDF
    const doc = new jsPDF();

    // Define la ruta de la imagen que deseas agregar
    const imagen = 'ruta/a/la/imagen.jpg';

    // Carga la imagen utilizando la función toDataURL
    const imgData = getBase64Image(imagen);

    // Agrega la imagen al documento PDF
    doc.addImage(imgData, 'JPEG', 10, 10, 50, 50); // Ajusta las coordenadas y dimensiones según tus necesidades

    // Guarda el documento PDF
    doc.save('archivo.pdf');
  }

  function getBase64Image(url) {
    const img = new Image();
    img.src = url;
    img.crossOrigin = 'Anonymous';

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    return new Promise((resolve) => {
      img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);
        resolve(canvas.toDataURL('image/jpeg'));
      };
    });
  }
