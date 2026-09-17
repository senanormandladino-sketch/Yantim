async function procesarPagoPedido(itemsPedido) {
    if (!itemsPedido || itemsPedido.length === 0) {
        alert('No hay productos para procesar.');
        return;
    }

    const totalPedido = itemsPedido.reduce((acc, item) => acc + (parseFloat(item.precio) * parseInt(item.cantidad)), 0);

    const payload = {
        total: totalPedido,
        items: itemsPedido
    };

    const urlControlador = window.location.pathname.includes('/View/') 
        ? '../Controller/PedidoController.php?accion=procesar' 
        : 'Controller/PedidoController.php?accion=procesar';

    try {
        const respuesta = await fetch(urlControlador, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const textoRespuesta = await respuesta.text();
        let resultado;

        try {
            resultado = JSON.parse(textoRespuesta);
        } catch (e) {
            console.error("Respuesta cruda del servidor:", textoRespuesta);
            throw new Error("El servidor devolvió una respuesta no válida. Verifique si inició sesión.");
        }

        if (resultado.status === 'success') {

            if (window.jspdf && window.jspdf.jsPDF) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });


                doc.setFont('helvetica', 'bold');
                doc.setFontSize(22);
                doc.setTextColor(242, 176, 7);
                doc.text('YANTIM', 105, 18, { align: 'center' });

                doc.setFont('helvetica', 'normal');
                doc.setFontSize(10);
                doc.setTextColor(100, 100, 100);
                doc.text('Comprobante Digital de Compra', 105, 24, { align: 'center' });

                doc.setDrawColor(242, 176, 7);
                doc.setLineWidth(0.8);
                doc.line(14, 28, 196, 28);


                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);

                doc.setFont('helvetica', 'bold');
                doc.text('N° de Pedido:', 14, 36);
                doc.setFont('helvetica', 'normal');
                doc.text(`#${resultado.id_pedido}`, 45, 36);

                doc.setFont('helvetica', 'bold');
                doc.text('Fecha de emisión:', 14, 42);
                doc.setFont('helvetica', 'normal');
                doc.text(`${new Date().toLocaleDateString('es-CO')}`, 45, 42);

                doc.setFont('helvetica', 'bold');
                doc.text('Estado del Pago:', 14, 48);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(34, 197, 94);
                doc.text('Completado / Pagado', 45, 48);
                doc.setTextColor(0, 0, 0);


                const clienteNombre = resultado.cliente_completo || 'Cliente General';
                const clienteEmail = resultado.email || 'No registrado';
                const clienteTelefono = resultado.telefono || 'No registrado';
                const clienteDocumento = resultado.documento || null;

                doc.setFont('helvetica', 'bold');
                doc.text('INFORMACIÓN DEL CLIENTE', 115, 36);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9.5);

                let posY = 42;
                doc.text(`Nombre: ${clienteNombre}`, 115, posY);
                posY += 5;
                doc.text(`Email: ${clienteEmail}`, 115, posY);
                posY += 5;
                doc.text(`Teléfono: ${clienteTelefono}`, 115, posY);

                if (clienteDocumento) {
                    posY += 5;
                    doc.text(`Documento: ${clienteDocumento}`, 115, posY);
                }


                const filasTabla = itemsPedido.map(item => [
                    item.nombre,
                    item.cantidad.toString(),
                    `$${parseFloat(item.precio).toLocaleString('es-CO')}`,
                    `$${(item.precio * item.cantidad).toLocaleString('es-CO')}`
                ]);

                doc.autoTable({
                    startY: posY + 10,
                    head: [['Producto / Servicio', 'Cant.', 'Precio Unid.', 'Subtotal']],
                    body: filasTabla,
                    theme: 'striped',
                    headStyles: { fillColor: [30, 41, 59], textColor: [255, 255, 255], fontStyle: 'bold' },
                    columnStyles: {
                        0: { halign: 'left' },
                        1: { halign: 'center', cellWidth: 20 },
                        2: { halign: 'right', cellWidth: 35 },
                        3: { halign: 'right', cellWidth: 35 }
                    },
                    styles: { fontSize: 9, cellPadding: 3 }
                });


                const finalY = doc.lastAutoTable.finalY + 12;
                doc.setFillColor(248, 250, 252);
                doc.rect(125, finalY - 6, 71, 14, 'F');

                doc.setFontSize(12);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(0, 0, 0);
                doc.text(`Total Pagado:`, 130, finalY + 3);
                doc.setTextColor(217, 119, 6);
                doc.text(`$${totalPedido.toLocaleString('es-CO')}`, 192, finalY + 3, { align: 'right' });

                doc.setFontSize(8);
                doc.setFont('helvetica', 'italic');
                doc.setTextColor(120, 120, 120);
                doc.text('¡Gracias por tu compra en Yantim! Conserva este documento como tu comprobante.', 105, 280, { align: 'center' });

                doc.save(`Comprobante_Yantim_#${resultado.id_pedido}.pdf`);
            }

            localStorage.removeItem('carrito');
            window.location.href = window.location.pathname.includes('/View/') 
                ? 'mis_compras.php?pedido=exitoso' 
                : 'View/mis_compras.php?pedido=exitoso';
        } else {
            alert('Error: ' + resultado.message);
        }
    } catch (error) {
        console.error('Error en el proceso de compra:', error);
        alert(error.message);
    }
}