<style>
.v-select {
    margin-bottom: 5px;
}

.v-select .dropdown-toggle {
    padding: 0px;
}

.v-select input[type=search],
.v-select input[type=search]:focus {
    margin: 0px;
}

.v-select .vs__selected-options {
    overflow: hidden;
    flex-wrap: nowrap;
}

.v-select .selected-tag {
    margin: 2px 0px;
    white-space: nowrap;
    position: absolute;
    left: 0px;
}

.v-select .vs__actions {
    margin-top: -5px;
}

.v-select .dropdown-menu {
    width: auto;
    overflow-y: auto;
}


#branchDropdown .vs__actions button {
    display: none;
}

#branchDropdown .vs__actions .open-indicator {
    height: 15px;
    margin-top: 7px;
}


.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 450px;
    margin: 0px auto;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header {
    padding-bottom: 0 !important;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    overflow-y: auto !important;
    height: 300px !important;
    margin: -8px -14px -44px !important;
}

.modal-default-button {
    float: right;
}

.serialBtn {
    border: none;
    font-size: 13px;
    line-height: 0.38;
    margin-left: 2px;
    background-color: rgb(0 189 133) !important;
    height: 51px;
    padding: 18px;
    border-radius: 4px;
}

@media screen and (max-width:767px) {
    .mobile-full {
        width: 100% !important;
    }

    #sales {
        padding-top: 46px !important;
    }

    .mobile-left {
        width: 90% !important;
        float: left !important;
        display: inline-block;
    }

    .mobile-right {
        width: 10% !important;
        float: right;
    }

    .due-left {
        width: 50% !important;
        float: left;
    }

    .due-right {
        width: 50% !important;
        float: right;
    }

    .due,
    .discount,
    .transport-cost,
    .total,
    .paid,
    .vat,
    .sub-total {
        width: 100%;
    }

    .discount-left {
        width: 30% !important;
        float: left;
    }

    .discount-middle {
        width: 10%;
    }

    .discount-right {
        width: 60%;
        float: right;
    }

    .mobile-stock-design {
        width: 50% !important;
        float: left !important;
    }

    .formobile {
        margin-left: 0px;
        margin-right: 0px;
    }
}
</style>

<div id="productTransfer">
    <div class="row">

        <div style="display:none" id="serial-modal" v-if="" v-bind:style="{display:serialModalStatus?'block':'none'}">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-header">
                                <slot name="header">
                                    <h3>IMEI Number Add</h3>
                                </slot>
                            </div>
                            <div class="modal-body" style="overflow: hidden; height: 100%; margin: -8px -14px -44px;">
                                <slot name="body">
                                    <form @submit.prevent="imei_add_action">
                                        <div class="form-group">
                                            <div class="col-sm-12" style="display: flex;margin-bottom: 10px;">
                                                <textarea autocomplete="off" ref="imeinumberadd" id="imei_number"
                                                    name="imei_number" v-model="get_imei_number" class="form-control"
                                                    placeholder="please Enter Serial Number" cols="30"
                                                    rows="2"></textarea>
                                                <input type="submit" class="btn btn-sm btn primary serialBtn"
                                                    value="Add">
                                            </div>
                                        </div>
                                    </form>
                                </slot>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Serial</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(product, sl) in imei_cart">
                                            <th scope="row">{{ imei_cart.length - sl }}</th>
                                            <td>{{product.imeiNumber}}</td>
                                            <td>{{product.Product_Name}}</td>
                                            <td @click="remove_imei_item(product.imeiNumber)"> <span
                                                    class="badge badge-danger badge-pill" style="cursor:pointer"><i
                                                        class="fa fa-times"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <a class="btn" @click.prevent="serialHideModal"
                                    style="background: rgb(255 0 0) !important;border: none;font-size: 16px;padding: 5px 12px;}">Close</a>

                                <a class="btn" @click.prevent="serialHideModal"
                                    style="background: rgb(0 175 70) !important;border: none;font-size: 16px;padding: 5px 25px;">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="col-md-7">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Transfer Information</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main" style="min-height:117px;">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Transfer date</label>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control" v-model="transfer.transfer_date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Transfer by</label>
                                    <div class="col-md-8">
                                        <select class="form-control"
                                            v-bind:style="{display: employees.length > 0 ? 'none' : ''}"></select>
                                        <v-select v-bind:options="employees" v-model="selectedEmployee"
                                            label="Employee_Name"
                                            v-bind:style="{display: employees.length > 0 ? '' : 'none'}"></v-select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Transfer to</label>
                                    <div class="col-md-8">
                                        <select class="form-control"
                                            v-bind:style="{display: branches.length > 0 ? 'none' : ''}"></select>
                                        <v-select v-bind:options="branches" v-model="selectedBranch" label="Brunch_name"
                                            v-bind:style="{display: branches.length > 0 ? '' : 'none'}"></v-select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <textarea class="form-control" style="min-height:84px" placeholder="Note"
                                        v-model="transfer.note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Product Information</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main" style="min-height:117px;">
                        <div class="row">
                            <div class="col-md-9">
                                <form v-on:submit.prevent="addToCart()">
                                    <!-- <div class="form-group">
                                        <label class="control-label col-md-4">Product</label>
                                        <div class="col-md-8">
                                            <select class="form-control"
                                                v-bind:style="{display: products.length > 0 ? 'none' : ''}"></select>
                                            <v-select id="product" v-bind:options="products" v-model="selectedProduct"
                                                label="Product_Name" v-on:input="onChangeProduct"
                                                v-bind:style="{display: products.length > 0 ? '' : 'none'}"></v-select>
                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                        <label class="col-xs-3 control-label no-padding-right"> Product </label>
                                        <div class="col-xs-8">
                                            <v-select v-bind:options="products" v-model="selectedProduct"
                                                label="display_text" id="product" v-on:input="productOnChange">
                                            </v-select>
                                        </div>
                                        <div class="col-xs-1" style="padding: 0;">
                                            <a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger"
                                                style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                                target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                    aria-hidden="true" style="margin-top: 5px;"></i></a>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group" v-if="serials.length > 0">
                                        <label class="col-sm-4 control-label no-padding-right"> Serial </label>
                                        <div class="col-sm-8">
                                            <v-select v-bind:options="serials" v-model="serial"
                                                label="ps_serial_number"></v-select>
                                        </div>
                                    </div> -->


                                    <!-- <div class="form-group">
                                        <label class="control-label col-md-4">Quantity</label>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" v-model="quantity" ref="quantity"
                                                required v-on:input="productTotal"
                                                v-bind:disabled="serials.length ? true : false">
                                        </div>
                                    </div> -->

                                    <div class="form-group" v-if="selectedProduct.is_serial == 0">
                                        <label class="col-xs-3 control-label no-padding-right"> Quantity </label>
                                        <div class="col-xs-9">
                                            <input type="number" step="0.01" id="quantity" placeholder="Qty"
                                                class="form-control" ref="quantity" v-model="selectedProduct.quantity"
                                                v-on:input="productTotal" autocomplete="off"
                                                v-bind:disabled="selectedProduct.Is_Serial == 'true' ? true : false"
                                                required />
                                        </div>
                                    </div>

                                    <div class="form-group" v-else>
                                        <label class="col-xs-3 control-label no-padding-right"> Quantity </label>
                                        <div class="col-xs-9">
                                            <div class="row">
                                                <div class="col-xs-10 no-padding-right">
                                                    <input type="number" step="0.01" id="quantity" placeholder="Qty"
                                                        class="form-control" ref="quantity"
                                                        v-model="selectedProduct.quantity" v-on:input="productTotal"
                                                        autocomplete="off"
                                                        v-bind:disabled="selectedProduct.is_serial == 1 ? true : false"
                                                        required />
                                                </div>
                                                <div class="col-xs-2 no-padding-left">
                                                    <button type="button" id="show-modal" @click="serialShowModal"
                                                        style="background: rgb(210, 0, 0);color: white;border: none;font-size: 15px;height: 24px;margin-left: 1px;"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-4">Amount</label>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" v-model="selectedProduct.total"
                                                ref="total" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <input type="submit" class="btn btn-default pull-right btn-xs"
                                                value="Add to Cart">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-3">
                                <div
                                    style="width:100%;min-height:70px;background-color:#f5f5f5;text-align:center;border: 1px solid #8d8d8d;">
                                    <h6 style="padding:3px;margin:0;background-color:#8d8d8d;color:white;">Stock</h6>
                                    <div v-if="selectedProduct != null" style="display:none;"
                                        v-bind:style="{display: selectedProduct == null ? 'none' : ''}">
                                        <span style="padding:0;margin:0;font-size:18px;font-weight:bold;"
                                            v-bind:style="{color: productStock > 0 ? 'green' : 'red'}">{{ productStock }}</span><br>
                                        {{ selectedProduct.Unit_Name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Purchase Rate</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none" v-bind:style="{display:cart.length > 0 ? '' : 'none'}">
                        <tr v-for="(product, sl) in cart">
                            <td>{{ sl + 1 }}</td>
                            <td>{{ product.product_code }}</td>
                            <td>
                                {{ product.name }}
                                <div v-if="product.SerialStore.length">
                                    ({{ product.SerialStore.map(item => item.ps_serial_number).join(', ') }})
                                </div>
                            </td>
                            <td>
                                {{ product.quantity }}
                                 <input type="number" v-model="product.quantity"
                                    v-on:input="onChangeCartQuantity(product.product_id)"> -->
            <!-- </td>
            <td>{{ product.purchase_rate }}</td>
            <td>{{ product.total }}</td>
            <td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
            </tr>
            </tbody>
            </table> -->
            <!-- </div> -->

            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr class="">
                            <th style="width:10%;color:#000;">Sl</th>
                            <th style="width:25%;color:#000;">Product Name</th>
                            <th style="width:12%;color:#000;">Product Code</th>
                            <th style="width:7%;color:#000;">Qty</th>
                            <th style="width:8%;color:#000;">Rate</th>
                            <th style="width:15%;color:#000;">Total Amount</th>
                            <th style="width:15%;color:#000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                        <tr v-for="(product, sl) in cart">
                            <td>{{ sl + 1 }}</td>
                            <td v-if="product.SerialStore.length > 0">{{ product.name }}<br>
                                ({{ product.SerialStore.map(obj => obj.imeiNumber).join(', ') }})
                            </td>
                            <td v-else>{{ product.name }}</td>
                            <td>{{ product.productCode }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.purchaseRate }}</td>
                            <td>{{ product.total }}</td>
                            <td><a href="" v-on:click.prevent="removeFromCart(sl,product.SerialStore)"><i
                                        class="fa fa-trash"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row" style="display:none" v-bind:style="{display:cart.length > 0 ? '' : 'none'}">
        <div class="col-md-12">
            <button class="btn btn-success pull-right" v-on:click="saveProductTransfer">Save</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#productTransfer',
    data() {
        return {
            transfer: {
                transfer_id: parseInt('<?php echo $transferId;?>'),
                transfer_date: moment().format('YYYY-MM-DD'),
                transfer_by: '',
                transfer_from: '',
                transfer_to: '',
                note: '',
                total_amount: 0.00,
            },
            serials: [],
            serial: null,
            psId: null,
            psSerialNumber: '',
            cart: [],
            employees: [],
            selectedEmployee: null,
            branches: [],
            selectedBranch: null,
            products: [],
            selectedProduct: {
                Product_SlNo: '',
                display_text: 'Select Product',
                Product_Name: '',
                Unit_Name: '',
                quantity: 0,
                Product_Purchase_Rate: '',
                Product_SellingPrice: 0.00,
                vat: 0.00,
                total: 0.00,
                warranty: 0,
                is_serial: ''
            },
            productStock: 0,
            quantity: '',
            total: '',
            serialModalStatus: false,
            get_imei_number: '',
            imei_cart: [],
            IMEIStore: [],
        }
    },
    watch: {
        async selectedProduct(product) {
            if (product == undefined) return;
            await this.getSerials(product.Product_SlNo)
        },
        async serial(serial) {
            if (serial == undefined) return;
            this.selectedProduct = this.products.find(item => item.Product_SlNo == serial.ps_prod_id)
            this.psId = serial.ps_id;
            this.psSerialNumber = serial.ps_serial_number;
            this.quantity = 1;
            this.total = parseFloat(this.selectedProduct.Product_Purchase_Rate) * parseFloat(this.quantity);
            this.productStock = await axios.post('/get_product_stock', {
                    productId: serial.ps_prod_id
                })
                .then(res => {
                    return res.data;
                })
            this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
        },
    },
    async created() {
        this.getEmployees();
        this.getBranches();
        this.getProducts();
        await this.GetIMEIList();

        if (this.transfer.transfer_id != 0) {
            await this.getTransfer();
        }
    },
    methods: {
        getEmployees() {
            axios.get('/get_employees').then(res => {
                this.employees = res.data;
            })
        },

        getBranches() {
            axios.get('/get_branches').then(res => {
                let currentBranchId = parseInt("<?php echo $this->session->userdata('BRANCHid');?>");
                let currentBranchInd = res.data.findIndex(branch => branch.brunch_id ==
                    currentBranchId);
                res.data.splice(currentBranchInd, 1);
                this.branches = res.data;
            })
        },

        async productOnChange() {

            if (this.selectedProduct.Product_SlNo == '') {
                return
            }

            if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0)) {
                this.productStock = await axios.post('/get_product_stock', {
                    productId: this.selectedProduct.Product_SlNo
                }).then(res => {
                    return res.data;
                })
                this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";

            }
            this.$refs.quantity.focus();
            this.p_discount_percent = 0;
            this.imei_cart = [];
        },

        serialShowModal() {
            this.serialModalStatus = true;
        },
        serialHideModal() {
            this.serialModalStatus = false;

            this.selectedProduct.quantity = this.imei_cart.length
            this.selectedProduct.total = (this.selectedProduct.quantity * this.selectedProduct
                .Product_Purchase_Rate).toFixed(2)
            this.productTotal()
            this.calculateTotal();
        },

        async imei_add_action() {

            if (this.selectedProduct.Product_SlNo == '') {
                alert("Please select a product");
                return false;
            } else {

                if (this.get_imei_number.trim() == '') {
                    alert("IMEI Number is Required.");
                    return false;
                }

                var lines = this.get_imei_number.split(/\n/);
                var output = [];
                for (var i = 0; i < lines.length; i++) {
                    if (/\S/.test(lines[i])) {
                        output.push($.trim(lines[i]));
                    }
                }

                for (let index = 0; index < output.length; index++) {

                    let imeiObj = this.IMEIStore.find(obj => obj.ps_serial_number == output[index] && obj
                        .ps_prod_id == this.selectedProduct.Product_SlNo);

                    let cartInd = this.imei_cart.findIndex(p => p.imeiNumber == output[index].trim());
                    if (cartInd > -1) {
                        alert('IMEI Number already exists in IMEI List');
                        return false;
                    } else {

                        if (!imeiObj) {
                            alert(output[index] + ' not valid IMEI Number')
                        } else {

                            let imei_cart_obj = {
                                ps_id: imeiObj.ps_id,
                                imeiNumber: imeiObj.ps_serial_number,
                                Product_SlNo: imeiObj.Product_SlNo,
                                Product_Name: imeiObj.Product_Name,
                            }

                            this.imei_cart.unshift(imei_cart_obj);

                        }
                    }
                }

                this.selectedProduct.quantity = output.length;
                this.selectedProduct.total = (this.selectedProduct.quantity * this.selectedProduct
                    .Product_SellingPrice).toFixed(2)
                this.get_imei_number = '';
            }
        },
        async remove_imei_item(imeiNumber) {
            var newImeiCart = this.imei_cart.filter((el) => {
                return el.imeiNumber != imeiNumber;
            });
            this.imei_cart = newImeiCart;
        },

        async GetIMEIList() {
            await axios.get('/GetIMEIList').then(res => {
                this.IMEIStore = res.data;
            })
        },

        getProducts() {
            axios.get('/get_products').then(res => {
                this.products = res.data;
            })
        },

        async getSerials(productId) {
            await axios.post('/get_Serial_By_Prod', {
                    prod_id: productId
                })
                .then(res => {
                    this.serials = res.data;
                })
        },

        calculateTotal() {

            // this.sales.subTotal = this.cart.reduce((prev, curr) => {
            //     return prev + parseFloat(curr.total)
            // }, 0).toFixed(2);

            // this.sales.vat = this.cart.reduce((prev, curr) => {
            //     return +prev + +(curr.total * (curr.vat / 100))
            // }, 0);

            // if (event.target.id == 'discountPercent') {
            //     this.sales.discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.discountPercent)) /
            //         100).toFixed(2);
            // } else {
            //     this.discountPercent = (parseFloat(this.sales.discount) / parseFloat(this.sales.subTotal) * 100)
            //         .toFixed(2);
            // }

            // this.sales.transportCost = isNaN(this.sales.transportCost) || this.sales.transportCost == '' ? 0 :
            //     this.sales.transportCost;
            // this.sales.discount = isNaN(this.sales.discount) || this.sales.discount == '' ? 0 : this.sales
            //     .discount;
            // this.discountPercent = isNaN(this.discountPercent) || this.discountPercent == '' ? 0 : this
            //     .discountPercent;
            // this.sales.paid = isNaN(this.sales.paid) || this.sales.paid == '' ? 0 : this.sales.paid;

            // this.sales.total = ((parseFloat(this.sales.subTotal) + parseFloat(this.sales.vat) + parseFloat(this
            //     .sales.transportCost)) - parseFloat(this.sales.discount)).toFixed(2);
            // if (this.selectedCustomer.Customer_Type == 'G') {
            //     this.sales.paid = this.sales.total;
            //     this.sales.due = 0;
            // } else {
            //     if (event.target.id != 'paid') {
            //         this.sales.paid = 0;
            //     }
            //     this.sales.due = (parseFloat(this.sales.total) - parseFloat(this.sales.paid)).toFixed(2);
            // }
        },

        async onChangeProduct() {

            if (this.serials.length > 0) {
                this.quantity = 1;
            }
            if (this.selectedProduct == null) {
                return;
            }

            this.productStock = await this.getProductStock(this.selectedProduct.Product_SlNo);
            this.$refs.quantity.focus();
        },

        async getProductStock(productId) {
            let stock = await axios.post('/get_product_stock', {
                productId: productId
            }).then(res => {
                return res.data;
            })
            return stock;
        },

        // productTotal() {
        //     if (this.selectedProduct == null) {
        //         return;
        //     }
        //     this.total = this.quantity * this.selectedProduct.Product_Purchase_Rate;
        // },

        productTotal() {
            this.selectedProduct.quantity = this.selectedProduct.quantity == null || this.selectedProduct
                .quantity == '' ? 0 : this.selectedProduct.quantity,
                this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this
                    .selectedProduct.Product_SellingPrice)).toFixed(2);
        },

        // addToCart() {
        //     let product = {}

        //     product = {
        //         product_id: this.selectedProduct.Product_SlNo,
        //         product_code: this.selectedProduct.Product_Code,
        //         name: this.selectedProduct.Product_Name,
        //         quantity: this.quantity,
        //         total: this.total,
        //         purchase_rate: this.selectedProduct.Product_Purchase_Rate,
        //         SerialStore: [{
        //             ps_id: this.psId,
        //             ps_serial_number: this.psSerialNumber
        //         }]
        //     }

        //     if (this.selectedProduct == null) {
        //         alert('Select product');
        //         return;
        //     }
        //     // if (this.serials.length > 0 && this.serial == null) {
        //     //     alert('Select transfer imie number');
        //     //     return;
        //     // }
        //     if (this.productStock < this.quantity) {
        //         alert('Stock not available');
        //         return;
        //     }
        //     // let cartProduct = {
        //     //     product_id: this.selectedProduct.Product_SlNo,
        //     //     name: this.selectedProduct.Product_Name,
        //     //     product_code: this.selectedProduct.Product_Code,
        //     //     quantity: this.quantity,
        //     //     purchase_rate: this.selectedProduct.Product_Purchase_Rate,
        //     //     total: this.total
        //     // }

        //     let checkCart = this.cart.filter((item, ind) => {
        //         return item.product_id == this.selectedProduct.Product_SlNo;
        //     });

        //     let getCurrentInd = this.cart.findIndex((item) => {
        //         return item.product_id == this.selectedProduct.Product_SlNo;
        //     });

        //     if (checkCart.length > 0) {
        //         checkCart.map((item) => {
        //             let storeObj = item.SerialStore;
        //             if (storeObj.length && product.SerialStore.length) {
        //                 let checkSameI = item.SerialStore.findIndex((_item) => {
        //                     return product.SerialStore[0]['ps_serial_number'] == _item
        //                         .ps_serial_number;
        //                 })
        //                 if (checkSameI > -1) {
        //                     alert("Already Added !!");
        //                     return false;
        //                 } else {
        //                     storeObj.push(product.SerialStore[0]);
        //                     this.cart[getCurrentInd].quantity = storeObj.length;
        //                     this.cart[getCurrentInd].total = parseFloat(this.total) + parseFloat(this
        //                         .cart[getCurrentInd].total);
        //                 }
        //             } else {
        //                 if (getCurrentInd > -1) {
        //                     alert("Already Added !!");
        //                     return false;
        //                 }
        //             }
        //         })
        //     } else {
        //         this.cart.push(product);
        //     }

        //     // this.cart.push(product);

        //     this.selectedProduct = null;
        //     this.serial = null;
        //     this.quantity = '';
        //     this.total = '';
        //     this.psSerialNumber = '';
        //     let productSearchBox = document.querySelector('#product input[role="combobox"]');
        //     productSearchBox.focus();
        // },

        addToCart() {

            if (this.selectedProduct.Product_SlNo == '') {
                alert('Select a product');
                return;
            }

            if (this.selectedProduct.Product_SellingPrice == '' || this.selectedProduct.Product_SellingPrice ==
                0) {
                alert('Enter sales rate');
                return;
            }

            if (this.selectedProduct.quantity == 0 || this.selectedProduct.quantity == '') {
                alert('Enter quantity');
                return;
            }

            if (parseFloat(this.selectedProduct.quantity) > parseFloat(this.productStock) && this.sales
                .isService == 'false') {
                alert('Stock unavailable');
                return;
            }

            let product = {
                product_id: this.selectedProduct.Product_SlNo,
                productCode: this.selectedProduct.Product_Code,
                name: this.selectedProduct.Product_Name,
                vat: this.selectedProduct.vat,
                quantity: this.selectedProduct.quantity,
                total: this.selectedProduct.quantity * this.selectedProduct.Product_Purchase_Rate,
                purchaseRate: this.selectedProduct.Product_Purchase_Rate,
                SerialStore: this.selectedProduct.is_serial == 1 ? this.imei_cart : [],
            }

            let getCurrentInd = this.cart.findIndex((item) => {
                return (item.product_id == this.selectedProduct.Product_SlNo);
            });

            if (getCurrentInd > -1) {
                alert("The Product already added in the cart!");
                return;
            }

            this.cart.push(product);
            // document.querySelector('#product input[role="combobox"]').focus();

            this.clearProduct();
            this.calculateTotal();
            this.imei_cart = [];
        },

        async onChangeCartQuantity(productId) {
            let cartInd = this.cart.findIndex(product => product.product_id == productId);

            if (this.transfer.transfer_id == 0) {
                let stock = await this.getProductStock(productId);

                if (this.cart[cartInd].quantity > stock) {
                    alert('Stock not available');
                    this.cart[cartInd].quantity = stock;
                }
            }

            this.cart[cartInd].total = this.cart[cartInd].quantity * this.cart[cartInd].purchase_rate;

        },

        removeFromCart(cartInd) {
            this.cart.splice(cartInd, 1);
        },

        saveProductTransfer() {
            if (this.transfer.transfer_date == null) {
                alert('Select transfer date');
                return;
            }

            if (this.selectedEmployee == null) {
                alert('Select transfer by');
                return;
            }

            if (this.selectedBranch == null) {
                alert('Select branch');
                return;
            }

            this.transfer.total_amount = this.cart.reduce((p, c) => {
                return p + +c.total
            }, 0);

            this.transfer.transfer_by = this.selectedEmployee.Employee_SlNo;
            this.transfer.transfer_to = this.selectedBranch.brunch_id;

            let data = {
                transfer: this.transfer,
                cart: this.cart
            }

            let url = '/add_product_transfer';
            if (this.transfer.transfer_id != 0) {
                url = '/update_product_transfer';
            }
            axios.post(url, data).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    location.reload();
                }
            })
        },

        async getTransfer() {
            let transfer = await axios.post('/get_transfers', {
                transferId: this.transfer.transfer_id
            }).then(res => {
                return res.data[0];
            })

            this.transfer = transfer;

            this.selectedEmployee = {
                Employee_SlNo: transfer.transfer_by,
                Employee_Name: transfer.transfer_by_name
            }

            this.selectedBranch = {
                brunch_id: transfer.transfer_to,
                Brunch_name: transfer.transfer_to_name
            }

            let transferDetails = await axios.post('/get_transfer_details', {
                    transferId: this.transfer.transfer_id
                })
                .then(res => {
                    return res.data;
                })

            transferDetails.forEach(td => {
                let cartProduct = {
                    product_id: td.product_id,
                    name: td.Product_Name,
                    product_code: td.Product_Code,
                    quantity: td.quantity,
                    purchase_rate: td.purchase_rate,
                    total: (td.purchase_rate * td.quantity),
                    SerialStore: []
                }

                td.serials.forEach((obj) => {
                    let serial_cart_obj = {
                        ps_id: obj.ps_prod_id,
                        ps_serial_number: obj.ps_serial_number
                    }
                    cartProduct.SerialStore.push(serial_cart_obj);
                })

                this.cart.push(cartProduct);
            });

        }
    }
})
</script>