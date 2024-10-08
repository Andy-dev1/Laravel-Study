<template>
    <div :class="estilo" role="alert">
        {{titulo}}
        <hr>
        <p>{{detalhes.mensagem}}</p>
        <!-- <span v-if="detalhes.data.message">{{detalhes.data.message}}</span> -->
        <!-- <span v-if="detalhes.data.id">{{'ID do registro: '+detalhes.data.id}}</span> -->
    </div>
</template>

<script>
    export default {
        props:['tipo','titulo','detalhes'],
        computed:{
            estilo(){
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>
