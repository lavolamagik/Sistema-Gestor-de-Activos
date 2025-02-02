@extends('layouts.app')  <!-- Esto extiende el layout app.blade.php -->
<!doctype html>
<html lang="en"></html>
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link href="{{asset('assets/estiloLogin.css')}}" rel="stylesheet">


    </head>

    <body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                <div class="row g-0">
                    <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">

                        <div class="text-center">
                        <img src="{{asset('pictures/Logo Empresas Iansa.png')}}"
                            style="width: 300px;" alt="logo">
                        </div>

                        <h2>Registrar nuevo usuario</h2>

                        <form action="/register" method="POST">
                            @csrf
                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="correo">Correo electrónico</label>
                                <input type="email" name="correo" id="correo" required class="form-control"/>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="nombres">Nombres:</label>
                                <input type="text" name="nombres" id="nombres" required class="form-control"><br><br>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="primerApellido">Primer apellido:</label>
                                <input type="text" name="primerApellido" id="primerApellido" required class="form-control"><br><br>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="segundoApellido">Segundo apellido (opcional):</label>
                                <input type="text" name="segundoApellido" id="segundoApellido" class="form-control"><br><br>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="contrasena">Contraseña:</label>
                                <input type="password" name="contrasena" id="contrasena" required class="form-control"><br><br>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="esAdministrador">¿Es administrador?</label>
                                <input type="checkbox" name="esAdministrador" id="esAdministrador" value="1"><br><br>
                            </div>

                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Registrar</button>
                        </form>
                        <a href="/dashboard" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Volver atrás</a>
                    </div>
                </div>
                </div>
                </div>
        </div>
        </div>
    </div>
    </body>
</html>
