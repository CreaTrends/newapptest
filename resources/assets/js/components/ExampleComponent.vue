<template>
<div class="my-3 p-3 bg-white rounded box-shadow">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
            </button>
        </div>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="10px">ID</th>
                    <th>Curso nivel</th>
                    <th colspan="3">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                
                <tr v-for="user in users">
                    <td width="10px">{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td width="10px">
                        <a href="#" class="btn btn-warning btn-sm" @click.prevent="editUser(user.id)">Editar</a>
                    </td>
                    <td width="10px">
                        <a href="#" class="btn btn-danger btn-sm" >Eliminar</a>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
</template>
<script>
// register modal component
export default {
props: ['data'],
data() {
return {
users : [],
user : {
'id' : '',
'name' : ''
},
title:'hola '
}
},
methods:{
fetchUsers(){
},
editUser(id){
this.$emit('testedit', id);
},
},
mounted() {
this.users = this.data;
this.user.name = this.data.name;
console.log(this.user.name)
}
}
</script>