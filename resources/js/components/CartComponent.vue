<template>
    <div class="card">
        <div class="card-body"><p>My Cart <i class="em em-shopping_trolley" aria-role="presentation" aria-label="SHOPPING TROLLEY"></i> </p></div>
        <ul>
            <table class="table table-condensed">
                <thead>
                    <th>Item</th>                    
                    <th>Amount</th>                    
                    <th></th>                     
                    <th>Qty</th>                     
                    <th>Total</th>                    
                </thead>
                <tbody>
                    <tr v-for="item in cart" :key="item.id">
                        <td v-text="item.name"></td>
                        <td v-text="toNumber(item.price)"></td>
                        <td> x </td>
                        <!-- <td><button>-</button><input type="number" min="1" :max="item.i_qty" v-model="item.qty" @keyup.enter="onEnter(item)" :id="item.id" @keydown="change(item)"><button>+</button></td> -->
                        <!-- <td><button class="btn-crement btn-default">-</button> <span class="item_quantity"><b>{{ item.qty }}</b></span><button class="btn-crement btn-default">+</button></td> -->
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-secondary" @click="decrement(item)">-</button>
                            <button type="button" class="btn btn-secondary" disabled>{{ item.qty }}</button>
                            <button type="button" class="btn btn-secondary" @click="increment(item)">+</button>
                            </div>
                        </td>
                        <td><b>{{ toNumber(item.total) }}</b></td>
                    </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>Total:</b></td>
                    <td><b>{{ toNumber(total) }}</b></td>
                </tr>
                </tbody>
            </table>
                


            
        </ul>
        <button class="btn btn-success"><font-awesome-icon icon="cart-plus" /> Checkout</button>
    </div>
</template>
<script>    
import numeral from 'numeral';
export default {

    mounted(){
        axios.get('/api/cart')
            .then((res)=>{
                this.cart = res.data
        });
        var channel = Echo.channel('cart-channel');
        channel.listen('.cart-added',(data)=>{

            console.log('hey')
            axios.get('/api/cart')
            .then((res)=>{
                this.cart = res.data
                this.cart = res.data
            });
        })
    },
    methods: {
        onEnter(item){
            this.showLoader()
            axios.post('/api/cart/update',
                {
                    item_id:item.item_id,
                    qty:item.qty
                })
                .then((res)=>{
                    console.log(res.msg);
                    this.hideLoader();
                })
        },
        showLoader(){
            this.loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                canCancel: true,
                onCancel: this.onCancel,
            });
        },
        hideLoader(){
            this.loader.hide()
        },
        increment(item){
            this.showLoader();
            item.qty = item.qty + 1
            axios.post('api/cart/update',{
                item_id:item.item_id,
                qty:item.qty
            })
            .then((res)=>{
                this.cart = res.data
                this.hideLoader();
            })
        },
        decrement(item){
            this.showLoader();
            item.qty = item.qty - 1
            axios.post('api/cart/update',{
                item_id:item.item_id,
                qty:item.qty
            })
            .then((res)=>{
                this.cart = res.data
                this.hideLoader();
            })
        },
        change(item){
            // axios.post('/api/cart/update',
            //     {
            //         item_id:item.item_id,
            //         qty:item.qty
            //     })
            //     .then((res)=>{
            //         console.log(res.msg);
            // })
        },
        test(){
            alert('from cartcomponent')
        },
        toNumber(number){
            var amount = numeral(number);
            return '₱ '+amount.format('0,0.00');
            
        },
        getAmount(price,qty){
            return price * qty;
        }
    },
    computed:{
        total(){
            var cart = this.cart;
            var total=0;
            var r_cart = cart.map(obj=>{
                total = total + obj.total
            });
            return total;
        }

    },
    data(){
        return{
            loader: '',
            cart: [],
        }
    }
}
</script>


<style scoped>

.btn-crement{
    padding-left: 20px;
    padding-right: 20px;
    border-color:gray;
    background-color: white;
    border-radius: 0.5em;

}
.item_quantity{
    padding-left: 10px;
    padding-right: 10px;
}
</style>