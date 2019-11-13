<template>
<div>
    <div>
        <button class="btn btn-success" style="float:right;margin-bottom:20px" @click="showStore">Bili Ulit</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width:1200px">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="em em-convenience_store" aria-role="presentation" aria-label="CONVENIENCE STORE"></i> Tindahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="Item">Search Item</label>
                            <input type="text" class="form-control" v-model="search"  placeholder="Search Item">
                        </div>
                        <table class="table table-striped" id="tblItems">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item) in filteredList" :key ="item.id">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.price }}</td>
                                    <td>{{ item.inventory.qty }}</td>
                                    <td><button class="btn btn-sm btn-success" @click="addToCart(item)">Add to Cart</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="col-6">
                <cart></cart>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>
</div>
</template>

<script>
import Swal from 'sweetalert2';
    export default {
        mounted() {
            axios.get("/api/items").then((res)=>{
                this.items = res.data
            })
        },
        methods:{
            test(){
                console.log('from purchase button component')
                this.$emit('test',this.name)
            },
            showStore(){
                $('#exampleModal').modal('show')
            },
            async addToCart(item){
                const { value: qty } = await Swal.fire({
                    input: 'number',
                    showCancelButton:true,
                    inputAttributes: {
                        min:1,
                        max: item.inventory.qty,
                    },
                    inputValidator: (value) => {
                        if(!value){
                            return 'Kelangan may laman';
                        }
                        if(value<1){
                            return 'Dapat hindi zero, bibili ka ba tapos 0? <br> Brainssss please! <br><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i>'
                        }
                        if(value==NaN){
                            return 'Wag Letters <br> Brainssss please! <br><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i><i class="em em-brain" aria-role="presentation" aria-label="BRAIN"></i>'
                        }
                        if(value>item.inventory.qty){
                            return 'Mas madami binibili mo kesa sa stock namin';
                        }
                        
                    },
                    inputPlaceholder: 'Qty'
                    })

                    if (qty) {
                        axios.post('/api/cart/add',
                        {
                            item_id:item.id,
                            qty:qty
                        })
                        .then(
                                Swal.fire({
                                title: 'Successfully Added to Cart',
                                width: 600,
                                padding: '3em',
                                background: '#fff url(https://sweetalert2.github.io//images/trees.png)',
                                backdrop: `
                                    rgba(0,0,123,0.4)
                                    url("https://sweetalert2.github.io/images/nyan-cat.gif")
                                    center left
                                    no-repeat
                                `
                                })
                        )
                        //this.cart.push({item:item,qty:qty})
                    }     
            }
        },
        computed: {
            filteredList(){
                // return this.items.filter(item=>{
                //     return item.name.toLowerCase().includes(this.search.toLowerCase());
                // });
                return this.items.filter((item) => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        data(){
            return {
                items: [],
                search:'',
                clickedItem: ''
            }
        }
    }
</script>

<style scoped>
    .swal2-container{
        z-index : 9999 !important
    }
</style>
