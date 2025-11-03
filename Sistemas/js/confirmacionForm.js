function confirmarEnvioFormulario(formulario, campos, titulo, mensajeConfirmacion) {
	if (!formulario) return;

	let datos = [];

	campos.forEach(campo => {
		const { id, label, esSelect = false, formatoFecha = false } = campo;
		const el = formulario.querySelector(`#${id}`);
		if (!el) return;

		let valor = "";
		if (esSelect) {
			valor = el.options[el.selectedIndex]?.text.trim();
		} else {
			valor = el.value?.trim();
			if (formatoFecha && valor) {
				// 🔧 Evita conversión UTC → local
				const [year, month, day] = valor.split("-");
				valor = `${day.padStart(2, "0")}/${month.padStart(2, "0")}/${year}`;
			}
		}

		if (valor && valor !== "-SELECCIONE UNA-") {
			datos.push(`<li><strong>${label}:</strong> ${valor.toUpperCase()}</li>`);
		}
	});

	const html = `
		<h3 style="margin-bottom:10px;">${titulo}</h3>
		<ul style="text-align:left; margin-bottom: 15px;">
			${datos.join('')}
		</ul>
		<p><strong>${mensajeConfirmacion}</strong></p>
	`;

	Swal.fire({
		html: html,
		icon: "warning",
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonColor: '#198754',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Confirmar',
		cancelButtonText: "Cancelar",
		reverseButtons: true,
		title: `<span style="color: #333;">${titulo}</span>`
	}).then(result => {
		if (result.isConfirmed) {
			formulario.submit();
		}
	});
}

// Función genérica de alerta
function showAlert(title, type = "success", confirmText = "Aceptar", confirmColor = null) {
    // colores por defecto según tipo si no se pasan
    const defaultColors = {
        success: "#198754",
        error: "#d33",
        warning: "#f0ad4e",
        info: "#0dcaf0"
    };

    Swal.fire({
        title: title,
        icon: type,
        showConfirmButton: true,
        confirmButtonText: confirmText,
        confirmButtonColor: confirmColor || defaultColors[type] || "#198754",
        customClass: {
            actions: 'reverse-button'
        }
    });
}

