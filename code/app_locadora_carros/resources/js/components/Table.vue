<template>
    <table class="table table-hover">
        <thead>
            
            <tr >
                <th scope="col" v-for="t,key in titulos" :key="key" class="text-uppercase">{{t}}</th>
                
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj in dados" :key="obj.id">
                <td v-for="valor, chave in obj" :key="chave" >
                    <p v-if="titulos.includes(chave)">
                        <span v-if="chave == 'imagem'">
                            <img :src="'/storage/' + valor" width="40" height="40">
                        </span>
                    
                        <span v-else>
                            {{ valor }}
                        </span>
                    </p>
                </td>
            </tr>
            
        </tbody>
       
    </table>
</template>

<script>
    export default {
      props:['dados','titulos'],
     
    }
</script>
