<template>
    <div class="container mt-4">
      <h1 class="display-4">{{ TituloForm }}</h1>
  
      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label for="primerNombre" class="form-label">Primer Nombre:</label>
          <input type="text" id="primerNombre" v-model="usuario.primer_nombre" class="form-control" required>
        </div>
  
        <div class="mb-3">
          <label for="segundoNombre" class="form-label">Segundo Nombre:</label>
          <input type="text" id="segundoNombre" v-model="usuario.segundo_nombre" class="form-control">
        </div>
  
        <div class="mb-3">
          <label for="primerApellido" class="form-label">Primer Apellido:</label>
          <input type="text" id="primerApellido" v-model="usuario.primer_apellido" class="form-control" required>
        </div>
  
        <div class="mb-3">
          <label for="segundoApellido" class="form-label">Segundo Apellido:</label>
          <input type="text" id="segundoApellido" v-model="usuario.segundo_apellido" class="form-control">
        </div>
  
        <div class="mb-3">
          <label for="departamento" class="form-label">Departamento:</label>
          <select id="departamento" v-model="usuario.id_departamento" class="form-select" required>
            <option v-for="departamento in listaDepartamentos" :key="departamento.id" :value="departamento.id">
              {{ departamento.nombre }}
            </option>
          </select>
        </div>
  
        <div class="mb-3">
          <label for="cargo" class="form-label">Cargo:</label>
          <select id="cargo" v-model="usuario.id_cargo" class="form-select" required>
            <option v-for="cargo in listaCargos" :key="cargo.id" :value="cargo.id">
              {{ cargo.nombre }}
            </option>
          </select>
        </div>
  
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico:</label>
          <input type="email" id="email" v-model="usuario.email" class="form-control" required>
        </div>
  
  
        <button type="submit" class="btn btn-primary mr-2">{{route.params.id_usuario ? 'Actualizar' : 'Guardar'}}</button>
        <button type="submit" class="btn btn-primary mr-2" @click="regresar()">Regresar</button>
      </form>
    </div>
  </template>
  
  <script setup>
  
  import { ref, onBeforeMount } from 'vue'
  import axios from 'axios'
  import { useRouter, useRoute } from "vue-router";
  
  const router = useRouter();
  const route = useRoute();
  const listaDepartamentos = ref([]);
  const listaCargos = ref([]);
  const TituloForm = ref('Nuevo Usuario')
  
  const usuario = ref({
    primer_nombre: '',
    segundo_nombre: '',
    primer_apellido: '',
    segundo_apellido: '',
    id_departamento: null,
    id_cargo: null,
    email: '',
  });

  onBeforeMount(async () => {

    if(route.params.id_usuario){
        TituloForm.value = 'Edición de Usuario';
        await axios.get('/api/usuarios/' + route.params.id_usuario)
        .then((result) => {
            const datosUsuario = result.data.data;
            for (const key in usuario.value) {
                if (datosUsuario.hasOwnProperty(key)) {
                usuario.value[key] = datosUsuario[key];
                }
            }
        })
        .catch((error) => {
            console.error(error);
        });
    }

    await axios.get('/api/departamentos')
      .then((result) => {
        console.log(result);
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

  function regresar(){
    router.push({
            path: '/',
        });
  }
  
  const submitForm = () => {
    
    if(route.params.id_usuario){
        axios.put('/api/usuario/' + route.params.id_usuario , usuario.value)
      .then(response => {
        console.log(response.data);
        router.push({
            path: '/',
        });
      })
      .catch(error => {
        console.error(error);
      });
    }else{
        axios.post('/api/usuarios', usuario.value)
      .then(response => {
        console.log(response.data);
        router.push({
            path: '/',
        });
      })
      .catch(error => {
        console.error(error);
      });
    }

    
  };
  </script>
  