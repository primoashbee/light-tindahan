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
                        <td><input type="number" min="1" :max="item.i_qty" v-model="item.qty" @keyup.enter="onEnter(item)" :id="item.id" @change="change(item)"></td>
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
            axios.post('/api/cart/add',
                {
                    item_id:item.item_id,
                    qty:item.qty
                })
                .then((res)=>{
                    console.log(res.msg);
                })
        },
        change(data){
            console.log(data.name)
        
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
            cart: [],
        }
    }
}
</script>