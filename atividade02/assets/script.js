const form = document.querySelector('#form')
const table = document.querySelector('#table>tbody')

const findPeople = async () => {
    try {
        const data = await fetch(form.getAttribute('action'), {
            method: 'GET',
            mode: 'cors'
        })

        const response = await data.json()
        const people = response.data;
        let html = "";

        people.map((person) => {
            html += `<tr>
                <td>${person['name']}</td>
                <td>${person['age']}</td>
                <td>${person['email']}</td>
                <td>${person['gender']}</td>
                <td>${person['notification']?"Sim":"Não"}</td>
            </tr>`;
        })

        if(html !== ""){
            table.innerHTML = html;
        }
        
        form.reset();

    } catch (error) {
        alert('Erro ao buscar registros.');
    }
}


form.addEventListener('submit', async event => {
    event.preventDefault();

    const formData = new FormData(form)

    console.log(document.querySelector('#notification').checked)

    form.setAttribute('notification', document.querySelector('#notification').checked)

    try {
        const data = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            mode: 'cors',
            body: formData
        })

        const response = await data.json()

        alert(response.message)

        findPeople();

    } catch (error) {
        console.error("Error: ", error)
    }
})

window.onload = () => {
    findPeople();
}