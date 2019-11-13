<template>
<div>
    <table class="table table-striped">
        <thead>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </thead>
        <tbody>
            <tr>
                <td>Pagkain</td>
                <td>2</td>
                <td>24.00</td>
                <td>48.00</td>
            </tr>
            <tr>
                <td>Pagkain</td>
                <td>2</td>
                <td>24.00</td>
                <td>48.00</td>
            </tr>
            <tr>
                <td>Pagkain</td>
                <td>2</td>
                <td>24.00</td>
                <td>48.00</td>
            </tr>
        </tbody>
    </table>

    <p><b>Total Purchased: 150.00</b></p>
</div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
