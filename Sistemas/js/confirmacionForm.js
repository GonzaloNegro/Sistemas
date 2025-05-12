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
				const fecha = new Date(valor);
				valor = fecha.toLocaleDateString('es-AR', {
					day: '2-digit',
					month: '2-digit',
					year: 'numeric'
				});
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
