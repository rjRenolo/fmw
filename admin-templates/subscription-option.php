<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

<?php
if(empty(get_option('stripe_secret_key'))){ ?>
    <h3>Stripe secret key is missing</h3>
<?php }else{ ?>


<div id="subscription-option">
<?php 
echo 'subscription settings here';
?>
<h1>{{test}}</h1>

<ul>
    <li></li>
</ul>

</div>

<script>
var categPage = new Vue({
    el : "#subscription-option",
    data : {
        test : "Hello World"
    },
    created(){
        console.log('created')
    },
    mounted(){
        console.log('mounted')
    }
})
</script>


<?php }?>
