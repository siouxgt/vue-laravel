const fileCer = document.querySelector('#archivo_cer');
const dropCer = document.querySelector('#drop_cer');
const nombreCer = document.querySelector('#nombre_cer');

dropCer.addEventListener('click', () => fileCer.click())

dropCer.addEventListener('dragover', (e) => {
	e.preventDefault()
	dropCer.classList.remove('punteado');
	dropCer.classList.add('punteado-active');
})

dropCer.addEventListener('dragleave', (e) => {
	e.preventDefault()

	dropCer.classList.remove('punteado-active');
	dropCer.classList.add('punteado');
})


dropCer.addEventListener('drop', (e) => {
	e.preventDefault()

	fileCer.files = e.dataTransfer.files;
	const file = fileCer.files[0];
	if (file != undefined) {
		nombreArchivoCer(file);
	}
})

fileCer.addEventListener('change', (e) => {
	const file = e.target.files[0]
	nombreArchivoCer(file);
})

const nombreArchivoCer = (file) => {
	nombreCer.innerHTML = file.name;
}

const filekey = document.querySelector('#archivo_key');
const dropkey = document.querySelector('#drop_key');
const nombrekey = document.querySelector('#nombre_key');

dropkey.addEventListener('click', () => filekey.click())

dropkey.addEventListener('dragover', (e) => {
	e.preventDefault()
	dropkey.classList.remove('punteado');
	dropkey.classList.add('punteado-active');
})

dropkey.addEventListener('dragleave', (e) => {
	e.preventDefault()

	dropkey.classList.remove('punteado-active');
	dropkey.classList.add('punteado');
})


dropkey.addEventListener('drop', (e) => {
	e.preventDefault()

	filekey.files = e.dataTransfer.files;
	const file = filekey.files[0];
	if (file != undefined) {
		nombreArchivokey(file);
	}
})

filekey.addEventListener('change', (e) => {
	const file = e.target.files[0]
	nombreArchivokey(file);
})

const nombreArchivokey = (file) => {
	nombrekey.innerHTML = file.name;
}

if (document.querySelector("#archivo_banca") !== null) {
	const fileBanca = document.querySelector('#archivo_banca');
	const dropBanca = document.querySelector('#drop_banca');
	const nombreBanca = document.querySelector('#nombre_banca');

	dropBanca.addEventListener('click', () => fileBanca.click())

	dropBanca.addEventListener('dragover', (e) => {
		e.preventDefault()
		dropBanca.classList.remove('punteado');
		dropBanca.classList.add('punteado-active');
	})

	dropBanca.addEventListener('dragleave', (e) => {
		e.preventDefault()

		dropBanca.classList.remove('punteado-active');
		dropBanca.classList.add('punteado');
	})


	dropBanca.addEventListener('drop', (e) => {
		e.preventDefault()

		fileBanca.files = e.dataTransfer.files;
		const file = fileBanca.files[0];
		if (file != undefined) {
			nombreArchivoBanca(file);
		}
	})

	fileBanca.addEventListener('change', (e) => {
		const file = e.target.files[0]
		nombreArchivoBanca(file);
	})

	const nombreArchivoBanca = (file) => {
		nombreBanca.innerHTML = file.name;
	}
}