<?php
require '../common.php';

// если не залогинены или роль не совпадает - уходим через принудительный логаут
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../login/');
    exit;
}

$result = query("SELECT * FROM users");
// print_r(mysqli_fetch_row($result));
?>


<!DOCTYPE html>

<html lang="cs-cz">


<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin OpenStreetMap</title>

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"

          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css">

    <link rel="stylesheet" href="../css/style.css">

</head>


<body>


<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Administrátor</a>

    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">

        <span class="navbar-toggler-icon"></span>

    </button>


    <ul class="navbar-nav px-3">

        <li class="nav-item text-nowrap">

            <a class="nav-link" href="#" data-toggle="modal" data-target="#addNewUserModal">Přidání nového uživatele</a>

        </li>

    </ul>

</nav>


<div class="container-fluid">

    <div class="row">


        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">

            <div class="sidebar-sticky pt-3">

                <ul class="nav flex-column">


                    <li class="nav-item">

                        <a class="nav-link" href="../">

                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">

                                <path fill-rule="evenodd"
                                      d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>

                                <path fill-rule="evenodd"
                                      d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>

                            </svg>

                            Prohlédnout mapu

                        </a>

                    </li>


                    <li class="nav-item">

                        <a class="nav-link active" href="#">

                <span data-feather="home">

                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-people" fill="currentColor"
                       xmlns="http://www.w3.org/2000/svg">

                    <path fill-rule="evenodd"
                          d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>

                  </svg></span>

                  Uživatelé

                        </a>

                    </li>


                    <li class="nav-item">

                        <a class="nav-link" href="admin_grafs.php">

                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pie-chart"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                                <path fill-rule="evenodd"
                                      d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>

                                <path fill-rule="evenodd"
                                      d="M7.5 7.793V1h1v6.5H15v1H8.207l-4.853 4.854-.708-.708L7.5 7.793z"/>

                            </svg>

                            Informace

                        </a>

                    </li>


                    <li class="nav-item mt-2 ">

                        <a class="nav-link text-muted" href="#" data-toggle="modal" data-target="#logoutModal">

                        Odhlášení

                        </a>

                    </li>

                </ul>


            </div>

        </nav>


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">


            <h1>Tabulka uživatelů</h1>

            <div class="table-responsive">
            <table class="table table-sm table-striped table-need">
                <tr>
                    <th>id</th>
                    <th>Login</th>
                    <th>Role</th>
                    <th>Možnosti</th>
                </tr>
                <?php
                while ($res = mysqli_fetch_array($result)) {
                    ?>
                    <tr class="main-table">
                        <td class="td-needId"><?= $res['id'] ?></td>
                        <td class="td-need"><?= $res['log'] ?></td>
                        <td><?= $res['role'] ?></td>
                        <td><a class="edit_icon edit-elem" title="editovat" href="#" data-toggle="modal" data-target="#editUserModal"
                               onclick="getUserForEdit(<?= $res['id'] ?>)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd"
                                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a> | <a href="#" class="delete-elem" title="smazat" data-toggle="modal" data-target="#deleteUserModal"
                                      onclick="deleteUser(<?= $res['id'] ?>)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a></td>
                        </tr>
                        <?php
                        }
                    ?>
            </table>



            </div>

        </main>


        <div class="modal" tabindex="-1" id="addNewUserModal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Přidání nového uživatele</h5>

                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form id="addNewUserForm">

                            <div class="form-group">

                                <label for="addNewUser">Login nového uživatele</label>

                                <input type="text" class="form-control" id="addNewUser" required autofocus
                                       minlength="5" name="addNewUser">

                            </div>

                            <div class="form-group">

                                <label for="addNewUserPassword">Heslo</label>

                                <input type="password" class="form-control" id="addNewUserPassword" required
                                       minlength="5" name="addNewUserPassword">

                            </div>


                            <div class="form-group">

                                <label for="addNewUserRole">Vyberte roli uživatele</label>

                                <select class="form-control" id="addNewUserRole" name="addNewUserRole">

                                    <option value="redaktor">Správce</option>

                                    <option value="admin">Administrátor</option>

                                </select>

                            </div>


                            <div class="alert alert-success mt-2" role="alert" id="addNewUserAlertSuccess"
                                 style="display: none"></div>


                            <div class="alert alert-danger mt-2" role="alert" id="addNewUserAlertDanger"
                                 style="display: none"></div>
                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary" id="confirmAddNewUser">Přidat</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>

                    </div>

                </div>

            </div>

        </div>


        <div class="modal" tabindex="-1" id="editUserModal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Editace uživatelů</h5>

                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form id="userEditForm">

                            <div class="form-group">

                                <label for="editUser">Login nového uživatele</label>

                                <input type="text" class="form-control" id="editUser" required autofocus minlength="5"
                                       name="login">

                            </div>

                            <div class="form-group">

                                <label for="editUserPassword">Nové uživatelské heslo</label>

                                <input type="password" class="form-control" id="editUserPassword"
                                       minlength="5" name="password">

                            </div>


                            <div class="form-group">

                                <label for="editUserRole">Vyberte roli uživatele</label>

                                <select class="form-control" id="editUserRole" name="role">

                                    <option value="redaktor">Správce</option>

                                    <option value="admin">Administrátor</option>

                                </select>

                            </div>
                            <input type="hidden" id="editUserId" name="id">


                            <div class="alert alert-success mt-2" role="alert" id="editUserAlertSuccess"
                                 style="display: none"></div>


                            <div class="alert alert-danger mt-2" role="alert" id="editUserAlertDanger"
                                 style="display: none"></div>


                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary" id="confirmEdit">Upravit</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>

                    </div>

                </div>

            </div>

        </div>


        <div class="modal" tabindex="-1" id="deleteUserModal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Mazání uživatele</h5>

                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">
                        <p>Opravdu chcete smazat uživatele

                            <span class="delete__username" id="usernameForDelete">username</span>?</p>

                        <div class="alert alert-success mt-2" role="alert" id="deleteUserAlertSuccess"
                             style="display: none"></div>


                        <div class="alert alert-danger mt-2" role="alert" id="deleteUserAlertDanger"
                             style="display: none"></div>

                    </div>

                    <div class="modal-footer">
                        <form id="deleteUserForm">
                            <input type="hidden" name="deleteUserId" id="deleteUserId">
                            <button type="submit" class="btn btn-primary" id="confirmDeleteUser">Smazat uživatele</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>

                    </div>

                </div>

            </div>

        </div>


        <div class="modal" tabindex="-1" id="logoutModal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Opravdu se chcete odhlásit?</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne, zavřít</button>

                        <a href="../login/logout.php" type="button" class="btn btn-success">Odhlásit se</a>

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"

        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"

        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">

</script>

<script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/auto-refresh/bootstrap-table-auto-refresh.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/admin.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>


</body>


</html>