var idnow = 1;

function generateRow() {
    var id = idnow++;
    if (id > 5) {
        html = '<div class="alert alert-danger" role="alert">Maximální počet uživatelů je 5</div>';
        $('#userInputs').append(html);
        $('#addUser').prop('disabled', true);
        return;
    }
    var html = '<div class="input-group mb-3">\n' +
        '    <span class="input-group-text"><i class="fa fa-user"></i></span>\n' +
        '    <div class="form-floating">\n' +
        '        <input type="text" class="form-control" name="username[' + id + ']" id="username_' + id + '" placeholder="name" required>\n' +
        '        <label for="username_' + id + '">Jméno</label>\n' +
        '    </div>\n' +
        '    <span class="input-group-text">@</span>\n' +
        '    <div class="form-floating">\n' +
        '        <input type="email" class="form-control" name="email[' + id + ']" id="email_' + id + '" placeholder="name@example.com" required>\n' +
        '        <label for="email_' + id + '">Email</label>\n' +
        '    </div>\n' +
        '    <span class="input-group-text"><i class="fa fa-lock"></i></span>\n' +
        '    <div class="form-floating">\n' +
        '        <input type="text" class="form-control" name="password[' + id + ']" id="password_' + id + '" required>\n' +
        '        <label for="password_' + id + '">Heslo</label>\n' +
        '    </div>\n' +
        '    <span class="input-group-text"><i class="fa fa-black-tie"></i></span>\n' +
        '    <div class="form-floating">\n' +
        '        <input type="number" id="rights_' + id + '" name="admin[' + id + ']" min="0" max="10" value="0" class="form-control" required>\n' +
        '        <label for="rights_' + id + '">Oprávnění</label>\n' +
        '    </div>\n' +
        '</div>';

    // Append the generated HTML to #usersInput
    $('#userInputs').append(html);
}

generateRow(1)