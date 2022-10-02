@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h2>Crud Listas</h2>
            <input type="hidden" id="id">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="email" class="form-control" id="name" name="name" placeholder="Escriba un nombre">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripcion</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <button type="button" id="btnGuardar" class="btn btn-primary" onclick="store()">Guardar</button>

            <div class="d-flex">

                <button type="button" id="btnCancelar" style="display: none" class="btn btn-secondary "
                    onclick="reset()">cancelar</button>
                <button type="button" id="btnEditar" style="display: none" class="btn btn-primary ml-2"
                    onclick="update()">Editar</button>
            </div>
        </div>
        <br>
        <div class="alert alert-danger" id="errorDiv" style="display: none">
            <ul id="error">
            </ul>
        </div>
        <hr>
        <div class="responsive">
            <h2>Resultados</h2>

            <table class="table table-striped">
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Accion</th>
                </tr>

                <tbody id="resultados">

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const errorDiv = document.querySelector("#errorDiv");
        const btnEditar = document.querySelector("#btnEditar");
        const btnGuardar = document.querySelector("#btnGuardar");
        const btnCancelar = document.querySelector("#btnCancelar");


        const getData = () => {
            fetch('/api/lists')
                .then(response => response.json())
                .then(json => {
                    setResult(json);
                });
        }

        const deleteList = (id) => {
            fetch('/api/lists/' + id, {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                    },

                })
                .then(res => res.json())
                .then(res => {

                    if (res.errors) {
                        console.log(res.errors, "res");
                        setError(res);
                    } else {
                        getData();
                    }
                    console.log(res, "res");
                }).catch(err => console.error(err));
        }

        const showfetch = (id) => {
            fetch('/api/lists/' + id)
                .then(response => response.json())
                .then(json => {
                    // setResult(json);
                    document.querySelector("#id").value = json.data.id;
                    document.querySelector("#name").value = json.data.name;
                    document.querySelector("#description").value = json.data.description;
                });
        }

        const show = (id) => {
            reset();
            showfetch(id);
            btnGuardar.style.display = 'none';
            btnEditar.style.display = 'none';
            btnCancelar.style.display = 'block';
        }
        const edit = (id) => {
            reset();
            showfetch(id);
            btnGuardar.style.display = 'none';
            btnEditar.style.display = 'block';
            btnCancelar.style.display = 'block';
        }
        const store = () => {
            let name = document.querySelector("#name").value;
            let description = document.querySelector("#description").value;
            console.log("store", name, description);

            fetch('/api/lists', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        name,
                        description
                    })
                })
                .then(res => res.json())
                .then(res => {

                    if (res.errors) {
                        console.log(res.errors, "res");
                        setError(res);

                    } else {
                        getData();
                    }
                    console.log(res, "res");
                }).catch(err => console.error(err));

        }
        const update = () => {
            let id = document.querySelector("#id").value;
            let name = document.querySelector("#name").value;
            let description = document.querySelector("#description").value;
            console.log("update", name, description);

            fetch('/api/lists/' + id, {
                    method: 'PUT',
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        name,
                        description
                    })
                })
                .then(res => res.json())
                .then(res => {

                    if (res.errors) {
                        console.log(res.errors, "res");
                        setError(res);
                    } else {
                        getData();
                    }
                    console.log(res, "res");
                }).catch(err => console.error(err));

        }

        const setError = ({
            errors
        }) => {

            let resuslt = '';
            for (let error in errors) {
                // console.log(perro[clave]);
                errors[error].map(function(entidad, indice) {
                    console.log(entidad);
                    resuslt += `<li>` + entidad + `</li>`;
                });
            }

            const error = document.querySelector("#error");
            error.innerHTML = resuslt;
            errorDiv.style.display = 'block';
            console.log(errors)
        }

        const setResult = ({
            lists
        }) => {

            let resuslt = '';
            lists.map(function(entidad, indice) {
                resuslt += `
                        <tr>
                            <td>` + entidad.name + `</td>
                            <td>` + entidad.description + `</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="edit(` + entidad.id + `)">Editar</button>
                                <button type="button" class="btn btn-secondary" onclick="show(` + entidad.id + `)">Ver</button>
                                <button type="button" class="btn btn-danger" onclick="deleteList(` + entidad.id + `)">Eliminar</button>
                            </td>
                        </tr>
                        `;

                // console.log(entidad);
            });

            const body = document.querySelector("#resultados");
            body.innerHTML = resuslt;
            reset();
            // console.log(lists)

        }

        const reset = () => {
            document.querySelector("#id").value = "";
            document.querySelector("#name").value = "";
            document.querySelector("#description").value = "";
            btnGuardar.style.display = 'block';
            btnEditar.style.display = 'none';
            btnCancelar.style.display = 'none';
            errorDiv.style.display = 'none';
        }

        window.onload = function() {
            console.log("cargando datos");
            getData();
        }
    </script>
@endsection
