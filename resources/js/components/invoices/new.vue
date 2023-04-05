<template>
    <div class="container-n">

        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title" >New Invoice</h2>
                </div>
                <div>

                </div>
            </div>

            <div class="card__content">

                <div class="card__content--header">
                    <div>
                        <p class="my-1">NEW CUSTOMER ___</p>
                    </div>

                    <div>
                        <div>
                            <p class="my-1">Email</p>
                            <input type="email" class="input" v-model="newcustomer.email">
                            <br><br>
                            <div class="_radio">
                                <div>
                                    <p>is email correct ?</p>
                                </div>
                                <div>
                                    <a class="yes btn-secondary" @click="check2()">
                                        <h3>yes</h3>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <p class="my-1">First_Name</p>
                        <input type="text" class="input" v-model="newcustomer.firstname">
                        <p class="my-1">Last_Name</p>
                        <input type="text" class="input" v-model="newcustomer.lastname">

                        <p class="my-1">Address</p>
                        <input type="text" class="input" v-model="newcustomer.address">
                        <br><br><br>
                        <a class="btn btn-secondary my-3" @click="savecustomer()">
                            add
                        </a>
                        <br><br><br>
                        <div>
                            <p class="my-1">
                                SELECT ID
                            </p>
                            <select name="" id="" class="input" v-model="customer_id">
                                <option disabled>select id</option>
                                <option disabled></option>
                                <option :value="customer.id" v-for="customer in searchedcustomer" :key="customer.id">
                                    id : {{ customer.id }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Select from Existing Customers -->
                <div class="card__content--header">
                    <p class="my-1">
                        OLD CUSTOMER
                    </p>
                    <select name="" id="" class="input" v-model="customer_id">
                        <option disabled>select id</option>
                        <option disabled></option>
                        <option :value="customer.id" v-for="customer in allcustomers" :key="customer.id">
                               id : {{ customer.id }}{{ " " }} {{ " " }}{{"/"}} {{ customer.firstname }} {{ customer.lastname }}
                        </option>
                    </select>
                </div>

                <hr>
                <br><br>

                <!--shows new/selected customer id-->
                <div class="drop_required">
                    <p>
                       <h4>Customer ID</h4>
                    </p>
                    <p>
                        <input type="text" id="cusID"  class="input" v-model="customer_id">
                    </p>
                </div>


                <div class="card__content--header">
                    <div>
                        <p class="my-1">Date</p>
                        <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> <!---->
                        <p class="my-1">Due Date</p>
                        <input id="due_date" type="date" class="input" v-model="form.due_date">
                    </div>
                    <div>
                        <p class="my-1">Number</p>
                        <input type="text" class="input" v-model="form.number">
                        <p class="my-1">Reference(Optional)</p>
                        <input type="text" class="input" v-model="form.reference">
                    </div>
                </div>

                <br><br>

                <!-- Table -->
                <div class="table">
                    <!--Table headings-->
                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Quantity</p>
                        <p>Total</p>
                    </div>

                    <!-- item -->
                    <div class="table--items2" v-for="(itemcart, i) in listCart" :key="itemcart.id">
                        <p>#{{ itemcart.item_code }} {{ itemcart.description }}</p>

                        <p>
                            <input type="text" class="input" v-model="itemcart.unit_price">
                        </p>

                        <p>
                            <input type="text" class="input" v-model="itemcart.quantity">
                        </p>

                        <p v-if="itemcart.quantity">
                            $ {{ (itemcart.quantity)*(itemcart.unit_price) }}
                        </p>
                        <p v-else></p>

                        <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem(i)">
                            &times;
                        </p>
                    </div>
                    <!--Button (Add new item)-->
                    <div style="padding: 10px 30px !important;">
                        <button class="btn btn-sm btn__open--modal" @click="openModel()">Add new Item</button>
                    </div>
                </div>

                <!--Table Footer-->
                <div class="table__footer">
                    <div class="document-footer">
                        <p style="color: gray;">Terms and Conditions</p>
                        <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions"></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>$ {{ SubTotal() }}</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input type="text" class="input" v-model="form.discount">
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ {{ Total() }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!--Buttons-->
            <div class="card__header" style="margin-top: 20px;">
                <!--back to previuos page-->
                <div>
                    <a class="btn btn-secondary" @click="back()">
                        Go Back
                    </a>
                </div>
                <!--save-->
                <div>
                    <a class="btn btn-secondary" @click="onSave()">
                        Save
                    </a>
                </div>
            </div>

            <br>

        </div>



        <!--add modal items-->
        <div class="modal main__modal " :class="{ show: showModel }">
            <div class="modal__content">
                <span class="modal__close" @click="closeModel()" style="color: red;">×</span>
                <h3 class="modal__title">Add Items</h3>
                <hr><br>
                <div class="modal__items">
                    <ul style="list-style:none">
                        <li v-for="(item, i) in listproducts" :key="item.id" style="display:grid;grid-template-columns:30px 350px 15px;align-items:center;padding-bottom:5px;">
                            <p>{{ i+1 }}</p>
                            <a href="#">{{ item.item_code }} {{ item.description }}</a>
                            <button @click="addCart(item)" style="border:1px solid #e0e0e0;width:35px;height:35px;cursor:pointer;color: blue;">
                                +
                            </button>
                        </li>
                    </ul>
                </div>

                <br>
                <hr>
                <!--
                    <div class="model__footer">
                        <button class="btn btn-light mr-2 btn__close--modal" @click="closeModel()">
                            Cancel
                        </button>
                    <button class="btn btn-light btn__close--modal ">Save</button>
                </div>
                -->
            </div>
        </div>

    </div>
</template>



<script setup>

import { onMounted, ref } from "vue"

import { useRouter } from 'vue-router'

    const router = useRouter()


    let form = ref([])
    let allcustomers = ref ([])

    let listproducts = ref([])
    let listCart = ref([])
    const showModel = ref(false)
    const hideModel = ref(true)

    let customer_id = ref([])
    let newcustomer = ref([])
    let searchedcustomer = ref([])


    onMounted(async () => {
        customerForm()
        indexForm()
        getAllCustomers()
        getproducts()

    })


    const customerForm = async () => {
        let response = await axios.get('/api/create_customer')
        //console.log('form', response.data)
        newcustomer.value = response.data
    }

    const indexForm = async () => {
        let response = await axios.get('/api/create_invoice')
        //console.log('form', response.data)
        form.value = response.data
    }

    // get all customers from customers table & then assign them to allcustomers
    const getAllCustomers = async () => {
        let response = await axios.get('/api/customers')
        //console.log('response', response)
        allcustomers.value = response.data.customers
    }


    //check whether customer already exist or not using email then call to alert1()
    const check2 = async () => {
        let response = await axios.get('/api/search_customer?sandu=' + newcustomer.value.email)
        console.log('response', response.data) //or  response.data.invoices
        searchedcustomer.value = response.data.customer

        alert1()

    }

    const alert1 = () => {
        if(searchedcustomer.value.length>=1) {
         return alert("customer already exist");
        }
    }

    //get the item(product) in listproducts when clicking + button and then assigning them to listcart
    const addCart = (item) => {
        const itemcart = {
            id : item.id,
            item_code : item.item_code,
            description : item.description,
            unit_price : item.unit_price,
            quantity : item.quantity
        }
        listCart.value.push(itemcart)
        closeModel()
    }
    // remove item(product) from listcart
    const removeItem = (i) => {
        listCart.value.splice(i,1)
    }


    const openModel = () => {
        showModel.value = !showModel.value
    }

    const closeModel = () => {
        showModel.value = !hideModel.value
    }

    //get all products from product table & assign them to listproducts
    const getproducts = async () => {
        let response = await axios.get('/api/products')
        //console.log('products', response)
        listproducts.value = response.data.products
    }

    // calculate the price for all items and their quantities
    const SubTotal = () => {
        let total = 0
        listCart.value.map((data)=>{
            total = total + (data.quantity*data.unit_price)
        })
        return total
    }

    // reduce the discount from total price
    const Total = () => {
        return SubTotal() - form.value.discount
    }


    //save new customer
    const savecustomer = async () => {

        const customerData = new FormData()
        customerData.append('firstname',newcustomer.value.firstname)
        customerData.append('lastname',newcustomer.value.lastname)
        customerData.append('email',newcustomer.value.email)
        customerData.append('address',newcustomer.value.address)

        await axios.post("/api/add_customer", customerData)

        await search()

        return alert("Saved")
    }

    //get the new customer's details back,for crate a new invoice.
    //searched by the email
    const search = async () => {
        let response = await axios.get('/api/search_customer?sandu=' + newcustomer.value.email)
        console.log('response', response.data) //or  response.data.invoices
        searchedcustomer.value = response.data.customer

    }




    //save new invoice
    const onSave = () => {


        if (listCart.value.length>=1){

            let subtotal = 0
            subtotal = SubTotal()

            let total = 0
            total = Total()

            const formData = new FormData()
            formData.append('invoice_item',JSON.stringify(listCart.value))
            formData.append('customer_id',customer_id.value)
            formData.append('date',form.value.date)
            formData.append('due_date',form.value.due_date)
            formData.append('number',form.value.number)
            formData.append('reference',form.value.reference)
            formData.append('discount',form.value.discount)
            formData.append('subtotal',subtotal)
            formData.append('total',total)
            formData.append('terms_and_conditions',form.value.terms_and_conditions)


            axios.post("/api/add_invoice", formData)
            listCart.value = []

            router.push('/')
        }

    }

    //move back to previous route
    const back = () => {
        router.push('/')
    }



</script>
