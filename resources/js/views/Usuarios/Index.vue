<template>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <p class="mb-0">Módulo de Administración</p>
      
      
          <h2 class="mb-4">Administración de Usuarios</h2>
  
          <div class="row mb-3">
            <div class="col-md-4">
              <select id="departamentoSelector" v-model="departamentoSeleccionado" class="form-select">
                <option :value=null>Seleccione un Departamento</option>
                <option v-for="departamento in listaDepartamentos" :key="departamento.id" :value="departamento.id">
                  {{ departamento.nombre }}
                </option>
              </select>
            </div>
  
            <div class="col-md-4">
              <select id="cargoSelector" v-model="cargoSeleccionado" class="form-select">
                <option :value=null>Seleccione un Cargo</option>
                <option v-for="cargo in listaCargos" :key="cargo.id" :value="cargo.id">
                  {{ cargo.nombre }}
                </option>
              </select>
            </div>
  
            <div class="col-md-4">
              <button @click="crearUsuario()" class="btn btn-primary mt-3 float-right">
                Crear Nuevo Usuario
              </button>
            </div>
          </div>
        </div>
          <div class="card-header">
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th class="small text-center">Primer Nombre</th>
                        <th class="small text-center">Primer Apellido</th>
                        <th class="small text-center">Departamento</th>
                        <th class="small text-center">Cargo</th>
                        <th class="small text-center">Email</th>
                        <th class="small text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(usuario, index) in listaUsuarios" :key="usuario.id">
                        <td></td>
                        <td class="small">{{ usuario.primer_nombre }}</td>
                        <td class="small">{{ usuario.primer_apellido }}</td>
                        <td class="small">{{ usuario.departamento.nombre }}</td>
                        <td class="small">{{ usuario.cargo.nombre }}</td>
                        <td class="small">{{ usuario.email }}</td>
                        <td class="text-center">
                        <button @click="editarUsuario(usuario.id)" class="btn btn-success btn-sm mr-2">
                        <i class="bi bi-pencil"></i> Editar
                        </button>
                        <button @click="eliminarUsuario(usuario.id, index)" class="btn btn-danger btn-sm mr-2">
                        <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                    </tr>
                    </tbody>
                </table>
            </div>
          <div class="mt-3">
            <p>Total de Registros: {{ registros }}</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onBeforeMount, computed, watch } from 'vue'
  import axios from 'axios'
  import { useRouter } from "vue-router";
  
  const router = useRouter();
  const listaUsuarios = ref([]);
  const listaDepartamentos = ref([]);
  const listaCargos = ref([]);
  const departamentoSeleccionado = ref(null);
  const cargoSeleccionado = ref(null);
  const registros = ref(0);

 
  watch([departamentoSeleccionado, cargoSeleccionado], async () => {
    await cargarUsuarios();
  });
  
  // Función para cargar la lista de usuarios desde la API
  const cargarUsuarios = async () => {
    await axios.get('/api/usuarios', {params:{
        departamento_id: departamentoSeleccionado.value,
        cargo_id: cargoSeleccionado.value
    }})
      .then((result) => {
        console.log(result);
        registros.value = result.data.data.total;
        listaUsuarios.value = result?.data.data.data;
      })
      .catch((error) => {
        console.error(error);
      });
  };
  
  // Cargar la lista de usuarios al montar el componente
  onBeforeMount(async () => {
    await cargarUsuarios();
  
    await axios.get('/api/departamentos')
      .then((result) => {
        listaDepartamentos.value = result?.data.data;
      })
      .catch((error) => {
        console.error(error);
      });
  
    await axios.get('/api/cargos')
      .then((result) => {
        listaCargos.value = result?.data.data;
      })
      .catch((error) => {
        console.error(error);
      });
  });
  
  // Funciones para manejar la navegación y operaciones CRUD
  const crearUsuario = () => {
    router.push({ path: 'Nuevo' });
  };
  
  const editarUsuario = (id) => {
    router.push({ path: 'Editar/' + id });
  };
  
  const eliminarUsuario = (id, index) => {
    axios.delete('/api/usuarios/' + id)
      .then(response => {
        console.log(response.data);
        listaUsuarios.value.splice(index, 1);
      })
      .catch(error => {
        console.error(error);
      });
  };
  </script>
  