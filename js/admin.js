// посылаем данные на сервер при изменении
$('#userEditForm').on('submit', function (e) {
    e.preventDefault();
    $('#confirmEdit').prop('disabled', true);
    let data = $('#userEditForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'userActs.php',
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#editUserAlertSuccess').html(response.message);
                $('#editUserAlertSuccess').show('500').delay(5000).hide('500');
                // получаем данные которые взяли с сервера
                getElement(response.data);
            } else {
                $('#editUserAlertDanger').html(response.message);
                $('#editUserAlertDanger').show('500').delay(5000).hide('500');
            }
            $('#confirmEdit').prop('disabled', false);
        }
    });
});

// посылаем данные на сервер при добавлении
$('#addNewUserForm').on('submit', function (e) {
    e.preventDefault();
    $('#confirAddNewUser').prop('disabled', true);
    let data = $('#addNewUserForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'userActs.php',
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#addNewUserAlertSuccess').html(response.message);
                $('#addNewUserAlertSuccess').show('500').delay(5000).hide('500');
                // получаем данные которые взяли с сервера
                addUser(response.data);
            } else {
                $('#addNewUserAlertDanger').html(response.message);
                $('#addNewUserAlertDanger').show('500').delay(5000).hide('500');
            }
            $('#confirAddNewUser').prop('disabled', false);
        }
    });
});

// посылаем данные на сервер при удалении
$('#deleteUserForm').on('submit', function (e) {
    e.preventDefault();
    $('#confirmDeleteUser').prop('disabled', true);
    let data = $('#deleteUserForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'userActs.php',
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#deleteUserAlertSuccess').html(response.message);
                $('#deleteUserAlertSuccess').show('500').delay(5000).hide('500');
                // получаем данные которые взяли с сервера
                removeElement(response.data);
            } else {
                $('#deleteUserAlertDanger').html(response.message);
                $('#deleteUserAlertDanger').show('500').delay(5000).hide('500');
            }
            $('#confirmDeleteUser').prop('disabled', false);
        }
    });
});

// инициализация функций
// функции, которые получают все данные из сервера и запускают render с этими данными
function getElement (data) {
    render(data);
}

function removeElement (data) {
    render(data);
}

function addUser (data) {
    render(data);
}

// получание первоначального id при изменении
function getUserForEdit(userId) {
    $.getJSON('userActs.php?getDataById=' + userId, function (data) {
        $('#editUser').val(data.login);
        if (data.role == 'admin') $('#editUserRole option:last').prop('selected', true);
        else $('#editUserRole option:first').prop('selected', true);
        $('#editUserId').val(data.id)
        getElement()
    });
}
// получание первоначального id при удалении
function deleteUser(userId) {
    $.getJSON('userActs.php?getDataById=' + userId, function (data) {
        $('#usernameForDelete').html(data.login);
        $('#deleteUserId').val(data.id)
        removeElement();

    });
}

// функция рендер, при которой мы получаем данные и выводим их в таблицу
function render (data) {

    if (data) {
        // сортировка по категориям таблицы
        const array_size = 3;

        const sliced_array = [];

        for (let i = 0; i < data.length; i += array_size) {
            sliced_array.push(data.slice(i, i + array_size));
        }

        let a = [];

        // создание элементов
        for (let i = 0; i < data.length / 3; i++) {
                const element = document.createElement('tr');
                const idTd = document.createElement('td');
                const logTd = document.createElement('td');
                const roleTd = document.createElement('td');
                const iconsTd = document.createElement('td');
                // добавляем класс
                element.classList.add('main-table');
                // вводим значения в колонки
                idTd.textContent = sliced_array[i][0];
                logTd.textContent = sliced_array[i][1];
                roleTd.textContent = sliced_array[i][2];

                iconsTd.innerHTML = "<a class='edit_icon edit-elem' href='#' data-toggle='modal' data-target='#editUserModal' onclick=getUserForEdit("+sliced_array[i][0]+")><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/> <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/></svg></a> | <a href='#' data-toggle='modal' data-target='#deleteUserModal' class='delete-elem' onclick=deleteUser("+sliced_array[i][0]+")><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-trash' fill='currentColor' xmlns='http://www.w3.org/2000/svg'> <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/><path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></a>";
                // все колонки с новым значением добавляем один элемент
                element.append(idTd, logTd, roleTd, iconsTd);
                a.push(element);
                
        }
        // очищаем старые данные
        $('.main-table').remove();
        // вывод нового значения 
        for (let i = 0; i < sliced_array.length; i++) {
            $('.table-need').append(a[i])
        }
    }
}