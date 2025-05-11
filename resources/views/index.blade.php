@extends('_layouts.main')

@php
    $jwt = STS\JWT\JWTFacade::get('api', [], now()->addMinutes(10));
@endphp

@section('content')
    <div class="container mx-auto p-4 w-full lg:w-1/2">
        <h1 class="text-3xl text-white">Lišákův obchod</h1>
        <shop-items
        token="{{ $jwt }}"
        ></shop-items>

    </div>
@endsection

@section('js-bottom')
    <script>
        const { createApp } = Vue;
        const app = createApp({
            setup(){

            }
        });

        const ShopItems = Vue.defineComponent({
            data(){
                return {
                    products: {
                        default: []
                    },
                    edit: {
                        default: null
                    }
                }
            },
            props: {
                token: {
                    type: String,
                    required: true
                }
            },
            mounted(){
                this.loadProducts();
            },
            template: `<div class="text-white mt-8">
                    <h2 class="text-2xl">Filtrace</h2>
                    <div class="flex items-center flex-row my-4 gap-8">
                        <div class="w-1/2 flex flex-row items-center gap-2">
                            <input type="text" name="query" placeholder="Vyhledat podle názvu" class="bg-gray-600 w-full">
                        </div>
                        <div class="w-1/2 flex flex-row items-center gap-2">
                            <input type="text" name="price" placeholder="Vyhledat podle ceny" class="bg-gray-600 w-full">
                        </div>
                        <button class="cursor-pointer bg-gray-400 px-2" v-on:click="loadProducts">Filtrovat</button>
                    </div>
                    <div class="grid grid-cols-4 items-center justify-between border-b border-white">
                        <p class="text-xl">Produkt</p>
                        <p class="align-self-end">Cena</p>
                        <p class="align-self-end">Na skladě</p>
                        <p class="align-self-end">Akce</p>
                    </div>
                <div v-for="product, id in products" class="flex items-start justify-between gap-8">
                   <div class="w-full grid grid-cols-4 items-center justify-between">
                        <p class="text-xl">
                            <input type="text" :name="'name-' + id" :value='product.name' v-if="edit === id" class="bg-gray-600 w-full">
                            <p v-else>\{\{ product.name \}\}</p>
                        </p>
                        <p class="align-self-end">
                            <input type="text" :name="'price-' + id" :value='product.price' v-if="edit === id" class="bg-gray-600 w-full">
                            <p v-else>\{\{ product.price \}\}</p>
                        </p>
                        <p class="align-self-end">
                            <input type="text" :name="'stock-' + id" :value='product.stock' v-if="edit === id" class="bg-gray-600 w-full">
                            <p v-else>\{\{ product.stock \}\}</p>
                        </p>
                        <div class="flex flex-col">
                            <p v-on:click="removeProduct(product.id)" class="text-red-500 cursor-pointer hover:text-red-400">Odebrat</p>
                            <div>
                                <p v-on:click="updateProduct(id, product.id)" class="cursor-pointer" v-if="edit === id">Uložit</p>
                                <p v-on:click="editProduct(id)" class="cursor-pointer" v-else>Upravit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`,
            methods: {
                loadProducts(){
                    const self = this;
                    axios.get('/api/products-list', {
                        params: {
                            token: this.token,
                            data: {
                                query: document.getElementsByName('query')[0].value,
                                price: document.getElementsByName('price')[0].value
                            }
                        }
                    })
                    .then(function (response){
                        self.products = response.data;
                    });
                },
                removeProduct(product_id){
                    const self = this;

                    axios.delete('/api/remove-product', null, {
                        params: {
                            token: this.token,
                            product_id: product_id
                        }
                    }).then(function(response){
                        if(response.status === 200){
                            self.loadProducts();
                        }
                    })
                },
                editProduct(product_id){
                    this.edit = product_id;
                },
                updateProduct(id,product_id){
                    const self = this;

                    axios.post('/api/update-product', null, {
                        params: {
                            token: this.token,
                            product_id: product_id,
                            data: {
                                name: document.getElementsByName('name-' + id)[0].value,
                                price: document.getElementsByName('price-' + id)[0].value,
                                stock: document.getElementsByName('stock-' + id)[0].value
                            }
                        }
                    }).then(function (){
                        self.edit = null;
                        self.loadProducts();
                    })
                }
            }
        });

        app.component("shop-items", ShopItems);

        app.mount("#app");
    </script>
@endsection
