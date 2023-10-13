const form = document.querySelector('#form')
const table = document.querySelector('#table')

form.addEventListener('submit', async event => {
    event.preventDefault();

    const formData = new FormData(form)

    try {
        const data = await fetch('api/Register.php', {
            method: 'POST',
            mode: 'cors',
            body: formData
        })

        const response = await data.json()

        console.log(response)

    } catch (error) {
        console.error("Error: ", error)
    }

})

document.onload(alert())