<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- #region busca de marcas -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o id da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component> 
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                     <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>

                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm me-md-2">Pesquisar</button>
                    </template>
                </card-component>
                <!-- #endregion busca de marcas -->
                <!-- #region relacao de marcas -->
                <card-component titulo="Relação de marcas">
                    <template v-slot:conteudo>
                        <table-component :dados="marcas" :titulos="['id','nome','imagem']"></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm me-md-2" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </template>
                </card-component>
                <!-- #endregion relacao de marcas -->
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar marca">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus=='adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus=='erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="NovoNomeHelp" texto-ajuda="Informe o nome da marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="NovoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                    </input-container-component>
                    {{nomeMarca}}
                </div>
                <div class="form-group">
                    <input-container-component titulo="Imagem da marca" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{arquivoImagem}}
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        

       
    </div>
</template>

<script>
    export default{
        data(){
            return{
                urlBase:'http://localhost:8000/api/v1/marca',
                nomeMarca:'',
                arquivoImagem:[],
                transacaoStatus: '',
                transacaoDetalhes:{},
                marcas:[]
            }
        },
        computed:{
            token(){
                let token = document.cookie.split(';').find(indice=>indice.includes('token='));
                token=token.split('=')[1];
                token='Bearer '+token;
                
                
                return token;
            }
        },
        methods:{
            carregarLista(){
                let config={
                    headers:{
                        
                        'Accept':'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(this.urlBase,config).then(response=>{
                    this.marcas=response.data;
                    // console.log(this.marcas);
                }).catch(errors=>{
                    console.log(errors);
                })
            },
            carregarImagem(e){
                this.arquivoImagem=e.target.files
            },
            salvar(){
                
                let formData= new FormData();
                formData.append('nome',this.nomeMarca);
                formData.append('imagem',this.arquivoImagem[0]);

                let config={
                    headers:{
                        'Content-Type':'multipart/form-data',
                        'Accept':'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(this.urlBase,formData,config)
                    .then(response=>{
                        this.transacaoStatus='adicionado'
                        this.transacaoDetalhes={
                            mensagem: 'ID do registro: '+ response.data.id
                        }
                        console.log(response);
                    })
                    .catch(errors=>{
                        this.transacaoStatus='erro'
                        this.transacaoDetalhes={
                            mensagem: errors.response.data.message,
                            dados:errors.response.data.errors
                        };
                        //console.log(errors.response.data.message);
                        
                    })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
