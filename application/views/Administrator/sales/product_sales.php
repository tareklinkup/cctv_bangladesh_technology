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

<div id="sales" class="row">

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
                                <div class="form-group">
                                    <div class="col-sm-12" style="display: flex;margin-bottom: 10px;">
                                        <textarea @input="testing" autocomplete="off" ref="imeinumberadd"
                                            id="imei_number" name="imei_number" v-model="get_imei_number"
                                            class="form-control" placeholder="please Enter Serial Number" cols="30"
                                            rows="2"></textarea>
                                        <input type="submit" class="btn btn-sm btn primary serialBtn" value="Add"
                                            @click="imei_add_action">
                                    </div>
                                </div>
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


    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
                <div class="col-sm-2">
                    <input type="text" id="invoiceNo" class="form-control" v-model="sales.invoiceNo" readonly />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Sales By </label>
                <div class="col-sm-2">
                    <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"
                        placeholder="Select Employee"></v-select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Sales From </label>
                <div class="col-sm-2">
                    <v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="selectedBranch"
                        disabled></v-select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3">
                    <input class="form-control" id="salesDate" type="date" v-model="sales.salesDate"
                        v-bind:disabled="userType == 'u' ? true : false" />
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Sales Information</h4>
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
                <div class="widget-main">

                    <div class="row">
                        <div class="col-lg-5 col-xs-12">
                            <div class="form-group clearfix" style="margin-bottom: 8px;">
                                <label class="col-xs-4 control-label no-padding-right"> Sales Type </label>
                                <div class="col-xs-8">
                                    <input type="radio" name="salesType" value="retail" v-model="sales.salesType"
                                        v-on:change="onSalesTypeChange"> Retail &nbsp;
                                    <input type="radio" name="salesType" value="wholesale" v-model="sales.salesType"
                                        v-on:change="onSalesTypeChange"> Wholesale
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Customer </label>
                                <div class="col-xs-7">
                                    <v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer"
                                        v-on:input="customerOnChange"></v-select>
                                </div>
                                <div class="col-xs-1" style="padding: 0;">
                                    <a href="<?= base_url('customer')?>" class="btn btn-xs btn-danger"
                                        style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                        target="_blank" title="Add New Customer"><i class="fa fa-plus"
                                            aria-hidden="true" style="margin-top: 5px;"></i></a>
                                </div>
                            </div>

                            <div class="form-group" style="display:none;"
                                v-bind:style="{display: selectedCustomer.Customer_Type == 'G' ? '' : 'none'}">
                                <label class="col-xs-4 control-label no-padding-right"> Name </label>
                                <div class="col-xs-8">
                                    <input type="text" id="customerName" placeholder="Customer Name"
                                        class="form-control" v-model="selectedCustomer.Customer_Name"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
                                <div class="col-xs-8">
                                    <input type="text" id="mobileNo" placeholder="Mobile No" class="form-control"
                                        v-model="selectedCustomer.Customer_Mobile"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-4 control-label no-padding-right"> Address </label>
                                <div class="col-xs-8">
                                    <textarea id="address" placeholder="Address" class="form-control"
                                        v-model="selectedCustomer.Customer_Address"
                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xs-12">
                            <form v-on:submit.prevent="addToCart">
                                <!-- <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Product </label>
                                    <div class="col-xs-8">
                                        <v-select v-bind:options="products" v-model="selectedProduct"
                                            label="display_text" v-on:input="productOnChange"></v-select>
                                    </div>
                                    <div class="col-xs-1" style="padding: 0;">
                                        <a href="<?= base_url('product')?>" class="btn btn-xs btn-danger"
                                            style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                            target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group">
                                    <label for="" class="col-xs-3 control-label no-padding-right">Serial &nbsp;</label>
                                    <input class="col-xs-3" type="radio" name="salesType" value="1"
                                        v-model="sales.productType" v-on:change="onProductTypeChange">

                                    <label for="" class="col-xs-3 control-label no-padding-right">Non Serial
                                        &nbsp;</label>
                                    <input type="radio" class="col-xs-3" name="salesType" value="0"
                                        v-model="sales.productType" v-on:change="onProductTypeChange">
                                </div> -->

                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-4" style="text-align:left">
                                        <input type="radio" name="salesType" value="1" v-model="sales.productType"
                                            v-on:change="onProductTypeChange"> Serial
                                    </div>

                                    <div class="col-xs-4 ">
                                        <input type="radio" name="salesType" value="0" v-model="sales.productType"
                                            v-on:change="onProductTypeChange"> Non Serial
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Product </label>
                                    <div class="col-xs-8">
                                        <v-select v-bind:options="products" v-model="selectedProduct"
                                            label="display_text" id="product" v-on:input="productOnChange"></v-select>
                                    </div>
                                    <div class="col-xs-1" style="padding: 0;">
                                        <a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger"
                                            style="height: 25px; border: 0; width: 27px; margin-left: -10px;"
                                            target="_blank" title="Add New Product"><i class="fa fa-plus"
                                                aria-hidden="true" style="margin-top: 5px;"></i></a>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;"
                                    :style="{display: serials.length > 0 ? '' : 'none'}">
                                    <label class="col-sm-3 control-label no-padding-right"> Serial </label>

                                    <div class="col-sm-9">
                                        <v-select v-bind:options="serials" v-model="serial" label="ps_serial_number">
                                        </v-select>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-xs-3 control-label no-padding-right"> Brand </label>
                                    <div class="col-xs-9">
                                        <input type="text" id="brand" placeholder="Group" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Sale Rate </label>
                                    <div class="col-xs-9">
                                        <input type="number" id="salesRate" placeholder="Rate" step="0.01" min="0"
                                            class="form-control" v-model="selectedProduct.Product_SellingPrice"
                                            v-on:input="productTotal" />
                                    </div>
                                    <!-- <label class="col-xs-1 control-label no-padding-right"> Qty</label>
                                    <div class="col-xs-4">
                                        <input type="number" min="0" step="0.01" id="quantity" placeholder="Qty"
                                            class="form-control" ref="quantity" v-model="selectedProduct.quantity"
                                            v-on:input="productTotal" autocomplete="off"
                                            v-bind:disabled="serials.length ? true : false" required />
                                    </div> -->
                                </div>

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

                                <div class="form-group" style="display:none;">
                                    <label class="col-xs-3 control-label no-padding-right"> Discount</label>
                                    <div class="col-xs-9">
                                        <span>(%)</span>
                                        <input type="text" id="productDiscount" placeholder="Discount"
                                            class="form-control" style="display: inline-block; width: 90%" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> Amount </label>
                                    <div class="col-xs-9">
                                        <input type="text" id="productTotal" placeholder="Amount" class="form-control"
                                            v-model="selectedProduct.total" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Warranty
                                        <small>(Month)</small> </label>
                                    <div class="col-sm-9">
                                        <input type="number" v-model.number="selectedProduct.warranty" min="0"
                                            class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-3 control-label no-padding-right"> </label>
                                    <div class="col-xs-9">
                                        <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div style="display:none;" v-bind:style="{display:sales.isService == 'true' ? 'none' : ''}">
                                <div class="text-center" style="display:none;"
                                    v-bind:style="{color: productStock > 0 ? 'green' : 'red', display: selectedProduct.Product_SlNo == '' ? 'none' : ''}">
                                    {{ productStockText }}</div class="text-center">

                                <input type="text" id="productStock" v-model="productStock" readonly
                                    style="border:none;font-size:20px;width:100%;text-align:center;color:green"><br>
                                <input type="text" id="stockUnit" v-model="selectedProduct.Unit_Name" readonly
                                    style="border:none;font-size:12px;width:100%;text-align: center;"><br><br>
                            </div>
                            <input type="password" ref="productPurchaseRate"
                                v-model="selectedProduct.Product_Purchase_Rate"
                                v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate"
                                readonly title="Purchase rate (click & hold)"
                                style="font-size:12px;width:100%;text-align: center;">

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                    <thead>
                        <tr class="">
                            <th style="width:10%;color:#000;">Sl</th>
                            <th style="width:25%;color:#000;">Product Name</th>
                            <th style="width:12%;color:#000;">Product Code</th>
                            <th style="width:12%;color:#000;">Unit</th>
                            <th style="width:7%;color:#000;">Qty</th>
                            <th style="width:8%;color:#000;">Rate</th>
                            <th style="width:8%;color:#000;">Discount</th>
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
                            <td>{{ product.productId }}</td>
                            <td>{{ product.unitName }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.salesRate }}</td>
                            <td>{{ product.SaleDetails_Discount }}</td>
                            <td>{{ product.total }}</td>
                            <td><a href="" v-on:click.prevent="removeFromCart(sl,product.SerialStore)"><i
                                        class="fa fa-trash"></i></a></td>
                        </tr>

                        <tr>
                            <td colspan="7"></td>
                        </tr>

                        <tr style="font-weight: bold;">
                            <td colspan="2">Note</td>
                            <td colspan="2" style="text-align:right">Total Qty = {{
                                cart.reduce((prev, cur) => { return prev + parseFloat(cur.quantity)}, 0).toFixed(2)
                             }}</td>
                            <td colspan="4">Total</td>
                        </tr>

                        <tr>
                            <td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Note"
                                    v-model="sales.note"></textarea></td>
                            <td colspan="5" style="padding-top: 15px;font-size:18px;">{{ sales.total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
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
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Sub
                                                    Total</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="subTotal" class="form-control"
                                                        v-model="sales.subTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right"> Vat </label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="vat" readonly="" class="form-control"
                                                        v-model="sales.vat" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <!-- <div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Discount Persent</label>

												<div class="col-xs-4">
													<input type="number" id="discountPercent" class="form-control" min="0" v-model="discountPercent" v-on:input="calculateTotal"/>
												</div>

												<label class="col-xs-1 control-label no-padding-right">%</label>

												<div class="col-xs-7">
													<input type="number" id="discount" class="form-control" min="0" v-model="sales.discount" v-on:input="calculateTotal"/>
												</div>

											</div> -->
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Transport
                                                    Cost</label>
                                                <div class="col-xs-12">
                                                    <input type="number" class="form-control" min="0"
                                                        v-model="sales.transportCost" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="display:none;">
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Round Of</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="roundOf" class="form-control" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Total</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="total" class="form-control"
                                                        v-model="sales.total" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Payment
                                                    Type</label>
                                                <div class="col-xs-12">
                                                    <select class="form-control" v-model="sales.payment_type"
                                                        style="padding: 0px;border-radius: 3px;">
                                                        <option value="cash">Cash</option>
                                                        <option value="bank">Bank</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="display: none;"
                                        :style="{display: sales.payment_type == 'bank' ? '' : 'none'}">
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Bank
                                                    Account</label>
                                                <div class="col-xs-12">
                                                    <v-select v-bind:options="accounts" v-model="selectedAccount"
                                                        label="display_text" placeholder="Select account"></v-select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label no-padding-right">Paid</label>
                                                <div class="col-xs-12">
                                                    <input type="number" id="paid" class="form-control" min="0"
                                                        v-model="sales.paid" v-on:input="calculateTotal"
                                                        v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? true : false" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-xs-12 control-label">Due</label>
                                                <div class="col-xs-6">
                                                    <input type="number" id="due" class="form-control"
                                                        v-model="sales.due" readonly />
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="number" id="previousDue" class="form-control"
                                                        v-model="sales.previousDue" readonly style="color:red;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-xs-6">
                                                    <input type="button" class="btn btn-default btn-sm" value="Sale"
                                                        v-on:click="saveSales"
                                                        v-bind:disabled="saleOnProgress ? true : false"
                                                        style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
                                                </div>
                                                <div class="col-xs-6">
                                                    <a class="btn btn-info btn-sm"
                                                        v-bind:href="`/sales/${sales.isService == 'true' ? 'service' : 'product'}`"
                                                        style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New
                                                        Sale</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#sales',
    data() {
        return {
            sales: {
                salesId: parseInt('<?php echo $salesId;?>'),
                invoiceNo: '<?php echo $invoice;?>',
                salesBy: '<?php echo $this->session->userdata("FullName"); ?>',
                salesType: 'retail',
                productType: '0',
                salesFrom: '',
                salesDate: '',
                customerId: '',
                employeeId: null,
                subTotal: 0.00,
                discount: 0.00,
                vat: 0.00,
                transportCost: 0.00,
                total: 0.00,
                paid: 0.00,
                previousDue: 0.00,
                due: 0.00,
                isService: '<?php echo $isService;?>',
                note: '',
                payment_type: 'cash',
                accountId: null
            },
            get_imei_number: '',
            vatPercent: 0,
            discountPercent: 0,
            cart: [],
            employees: [],
            selectedEmployee: null,
            branches: [],
            selectedBranch: {
                brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
                Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
            },
            imei_cart: [],
            IMEIStore: [],
            selectedIEMI: {
                Product_SlNo: '',
                display_text: 'Select Product',
                Product_Name: '',
                Unit_Name: '',
                quantity: 1,
                Product_Purchase_Rate: '',
                Product_SellingPrice: 0.00,
                vat: 0.00,

                total: 0.00,
                ps_prod_id: '',
                ps_serial_number: '',
                SaleDetails_Discount: 0,
                ProductCategory_Name: '',
                ProductCategory_ID: ''
            },
            serialModalStatus: false,
            customers: [],
            selectedCustomer: {
                Customer_SlNo: '',
                Customer_Code: '',
                Customer_Name: '',
                display_name: 'Select Customer',
                Customer_Mobile: '',
                Customer_Address: '',
                Customer_Type: ''
            },
            oldCustomerId: null,
            oldPreviousDue: 0,
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
                warranty: 0
            },
            productPurchaseRate: '',
            productStockText: '',
            productStock: '',
            saleOnProgress: false,
            sales_due_on_update: 0,
            userType: '<?php echo $this->session->userdata("accountType");?>',
            serials: [],
            serial: null,
            accounts: [],
            selectedAccount: null,
        }
    },
    watch: {
        async serial(serial) {
            if (serial == undefined) return;
            this.selectedProduct = this.products.find(item => item.Product_SlNo == serial.ps_prod_id)
            this.psId = serial.ps_id;
            this.psSerialNumber = serial.ps_serial_number;
            this.selectedProduct.quantity = 1;
            this.selectedProduct.total = parseFloat(this.selectedProduct.Product_SellingPrice) * parseFloat(
                this.selectedProduct.quantity);
            this.productStock = await axios.post('/get_product_stock', {
                    productId: serial.ps_prod_id
                })
                .then(res => {
                    return res.data;
                })
            this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
        },
        selectedAccount(account) {
            if (account == undefined) return;
            this.sales.accountId = account.account_id;
        }
    },
    async created() {
        this.sales.salesDate = moment().format('YYYY-MM-DD');
        await this.getEmployees();
        await this.getBranches();
        await this.getCustomers();
        await this.getAccounts();
        await this.GetIMEIList();
        this.getProducts();

        if (this.sales.salesId != 0) {
            await this.getSales();
        }
    },
    methods: {
        async getAccounts() {
            await axios.get('/get_bank_accounts')
                .then(res => {
                    this.accounts = res.data.map((item, display_text) => {
                        item.display_text = `${item.bank_name} - ${item.account_number}`;
                        return item;
                    });
                })
        },

        onProductTypeChange() {
            this.clearProduct();
            this.getProducts();
        },

        getEmployees() {
            axios.get('/get_employees').then(res => {
                this.employees = res.data;
            })
        },
        getBranches() {
            axios.get('/get_branches').then(res => {
                this.branches = res.data;
            })
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

                /** if (this.get_imei_number.trim() == '') {
                     alert("IMEI Number is Required.");
                     return false;
                 } **/

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

                        if (!imeiObj && imeiObj.length > 5) {
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
        async getCustomers() {
            await axios.post('/get_customers', {
                customerType: this.sales.salesType
            }).then(res => {
                this.customers = res.data;
                this.customers.unshift({
                    Customer_SlNo: 'C01',
                    Customer_Code: '',
                    Customer_Name: '',
                    display_name: 'General Customer',
                    Customer_Mobile: '',
                    Customer_Address: '',
                    Customer_Type: 'G'
                })
            })
        },
        getProducts() {
            axios.post('/get_products', {
                isService: this.sales.isService,
                productType: this.sales.productType,
            }).then(res => {
                if (this.sales.salesType == 'wholesale') {
                    this.products = res.data.filter((product) => product.Product_WholesaleRate > 0);
                    this.products.map((product) => {
                        return product.Product_SellingPrice = product.Product_WholesaleRate;
                    })
                } else {
                    this.products = res.data;
                }
            })
        },
        async GetIMEIList() {
            await axios.get('/GetIMEIList').then(res => {
                this.IMEIStore = res.data;
            })
        },
        productTotal() {
            this.selectedProduct.quantity = this.selectedProduct.quantity == null || this.selectedProduct
                .quantity == '' ? 0 : this.selectedProduct.quantity,
                this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this
                    .selectedProduct.Product_SellingPrice)).toFixed(2);
        },
        onSalesTypeChange() {
            this.selectedCustomer = {
                Customer_SlNo: '',
                Customer_Code: '',
                Customer_Name: '',
                display_name: 'Select Customer',
                Customer_Mobile: '',
                Customer_Address: '',
                Customer_Type: ''
            }
            this.getCustomers();

            this.clearProduct();
            this.getProducts();
        },
        async customerOnChange() {
            if (this.selectedCustomer.Customer_SlNo == '') {
                return;
            }
            if (event.type == 'readystatechange') {
                return;
            }

            if (this.sales.salesId != 0 && this.oldCustomerId != parseInt(this.selectedCustomer
                    .Customer_SlNo)) {
                let changeConfirm = confirm(
                    'Changing customer will set previous due to current due amount. Do you really want to change customer?'
                );
                if (changeConfirm == false) {
                    return;
                }
            } else if (this.sales.salesId != 0 && this.oldCustomerId == parseInt(this.selectedCustomer
                    .Customer_SlNo)) {
                this.sales.previousDue = this.oldPreviousDue;
                return;
            }

            await this.getCustomerDue();

            this.calculateTotal();
        },
        async getCustomerDue() {
            await axios.post('/get_customer_due', {
                customerId: this.selectedCustomer.Customer_SlNo
            }).then(res => {
                if (res.data.length > 0) {
                    this.sales.previousDue = res.data[0].dueAmount;
                } else {
                    this.sales.previousDue = 0;
                }
            })
        },
        // async productOnChange() {
        //     if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0) && this
        //         .sales.isService == 'false') {
        //         this.productStock = await axios.post('/get_product_stock', {
        //             productId: this.selectedProduct.Product_SlNo
        //         }).then(res => {
        //             return res.data;
        //         })

        //         this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";

        //         await axios.post('/get_Serial_By_Prod', {
        //                 prod_id: this.selectedProduct.Product_SlNo
        //             })
        //             .then(res => {
        //                 this.serials = res.data;
        //             })
        //     }

        //     this.$refs.quantity.focus();
        // },
        async productOnChange() {
            if (this.selectedProduct.Product_SlNo == '') {
                return
            }

            if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0) && this
                .sales.isService == 'false') {
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
        toggleProductPurchaseRate() {
            //this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.Product_Purchase_Rate : '';
            this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' :
                'text';
        },
        // addToCart() {
        //     let product = {}
        //     if (this.serials.length) {
        //         product = {
        //             productId: this.selectedProduct.Product_SlNo,
        //             categoryName: this.selectedProduct.ProductCategory_Name,
        //             name: this.selectedProduct.Product_Name,
        //             salesRate: this.selectedProduct.Product_SellingPrice,
        //             vat: this.selectedProduct.vat,
        //             quantity: this.selectedProduct.quantity,
        //             total: this.selectedProduct.total,
        //             purchaseRate: this.selectedProduct.Product_Purchase_Rate,
        //             warranty: this.selectedProduct.warranty ?? 0,
        //             SerialStore: [{
        //                 ps_id: this.psId,
        //                 ps_serial_number: this.psSerialNumber
        //             }]
        //         }
        //     } else {
        //         product = {
        //             productId: this.selectedProduct.Product_SlNo,
        //             categoryName: this.selectedProduct.ProductCategory_Name,
        //             name: this.selectedProduct.Product_Name,
        //             salesRate: this.selectedProduct.Product_SellingPrice,
        //             vat: this.selectedProduct.vat,
        //             quantity: this.selectedProduct.quantity,
        //             total: this.selectedProduct.total,
        //             purchaseRate: this.selectedProduct.Product_Purchase_Rate,
        //             warranty: this.selectedProduct.warranty ?? 0,
        //             SerialStore: []
        //         }
        //     }


        //     if (product.productId == '') {
        //         alert('Select Product');
        //         return;
        //     }

        //     if (this.selectedProduct.is_serial == 1 && product.SerialStore.length == 0) {
        //         alert('Select serial number. This product only serial availabe');
        //         return;
        //     }

        //     if (this.serials.length && this.serial == null) {
        //         alert('Select product serial');
        //         return;
        //     }

        //     if (product.quantity == 0 || product.quantity == '') {
        //         alert('Enter quantity');
        //         return;
        //     }

        //     if (product.salesRate == 0 || product.salesRate == '') {
        //         alert('Enter sales rate');
        //         return;
        //     }

        //     if (product.quantity > this.productStock && this.sales.isService == 'false') {
        //         alert('Stock unavailable');
        //         return;
        //     }

        //     let checkCart = this.cart.filter((item, ind) => {
        //         return (item.productId == this.selectedProduct.Product_SlNo) && (item.salesRate == this
        //             .selectedProduct.Product_SellingPrice);
        //     });

        //     let getCurrentInd = this.cart.findIndex((item) => {
        //         return (item.productId == this.selectedProduct.Product_SlNo) && (item.salesRate == this
        //             .selectedProduct.Product_SellingPrice);
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
        //                     this.cart[getCurrentInd].total = parseFloat(this.selectedProduct.total) +
        //                         parseFloat(this.cart[getCurrentInd].total);
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

        //     this.clearProduct();
        //     this.calculateTotal();
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

            if (this.selectedProduct.quantity == 0 || this.selectedProduct.quantity == '' || this
                .selectedProduct.quantity == undefined) {
                alert('Enter quantity');
                return;
            }

            if (parseFloat(this.selectedProduct.quantity) > parseFloat(this.productStock) && this.sales
                .isService == 'false') {
                alert('Stock unavailable');
                return;
            }

            let product = {
                productId: this.selectedProduct.Product_SlNo,
                productCode: this.selectedProduct.Product_Code,
                UnitName: this.selectedProduct.Unit_Name,
                name: this.selectedProduct.Product_Name,
                salesRate: this.selectedProduct.Product_SellingPrice,
                vat: this.selectedProduct.vat,
                quantity: this.selectedProduct.quantity,
                total: this.selectedProduct.total,
                purchaseRate: this.selectedProduct.Product_Purchase_Rate,
                SaleDetails_Discount: this.selectedProduct.discount,
                SerialStore: this.selectedProduct.is_serial == 1 ? this.imei_cart : [],
            }


            let getCurrentInd = this.cart.findIndex((item) => {
                return (item.productId == this.selectedProduct.Product_SlNo);
            });

            if (getCurrentInd > -1) {
                alert("The Product already added in the cart!");
                return;
            }

            this.cart.unshift(product);
            // document.querySelector('#product input[role="combobox"]').focus();

            this.clearProduct();
            this.calculateTotal();
            this.imei_cart = [];
        },
        removeFromCart(ind) {
            this.cart.splice(ind, 1);
            this.calculateTotal();
        },
        clearProduct() {
            this.selectedProduct = {
                Product_SlNo: '',
                display_text: 'Select Product',
                Product_Name: '',
                Unit_Name: '',
                quantity: 0,
                Product_Purchase_Rate: '',
                Product_SellingPrice: 0.00,
                vat: 0.00,
                total: 0.00,
                warranty: 0
            }
            this.productStock = '';
            this.productStockText = '';
            this.serial = null;
            this.serials = [];
        },
        calculateTotal() {
            this.sales.subTotal = this.cart.reduce((prev, curr) => {
                return prev + parseFloat(curr.total)
            }, 0).toFixed(2);
            this.sales.vat = this.cart.reduce((prev, curr) => {
                return +prev + +(curr.total * (curr.vat / 100))
            }, 0);
            if (event.target.id == 'discountPercent') {
                this.sales.discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.discountPercent)) /
                    100).toFixed(2);
            } else {
                this.discountPercent = (parseFloat(this.sales.discount) / parseFloat(this.sales.subTotal) * 100)
                    .toFixed(2);
            }

            this.sales.transportCost = isNaN(this.sales.transportCost) || this.sales.transportCost == '' ? 0 :
                this.sales.transportCost;
            this.sales.discount = isNaN(this.sales.discount) || this.sales.discount == '' ? 0 : this.sales
                .discount;
            this.discountPercent = isNaN(this.discountPercent) || this.discountPercent == '' ? 0 : this
                .discountPercent;
            this.sales.paid = isNaN(this.sales.paid) || this.sales.paid == '' ? 0 : this.sales.paid;

            this.sales.total = ((parseFloat(this.sales.subTotal) + parseFloat(this.sales.vat) + parseFloat(this
                .sales.transportCost)) - parseFloat(this.sales.discount)).toFixed(2);
            if (this.selectedCustomer.Customer_Type == 'G') {
                this.sales.paid = this.sales.total;
                this.sales.due = 0;
            } else {
                if (event.target.id != 'paid') {
                    this.sales.paid = 0;
                }
                this.sales.due = (parseFloat(this.sales.total) - parseFloat(this.sales.paid)).toFixed(2);
            }
        },

        testing() {
            // alert("Hello Test...");
            this.imei_add_action();
        },
        async saveSales() {
            if (this.selectedCustomer.Customer_SlNo == '') {
                alert('Select Customer');
                return;
            }
            if (this.cart.length == 0) {
                alert('Cart is empty');
                return;
            }
            if (this.sales.payment_type == 'bank' && this.sales.accountId == null) {
                alert('Select bank account');
                return;
            }
            if (this.sales.payment_type == 'bank' && this.sales.paid == 0) {
                alert('Paid amount is required');
                return;
            }

            this.saleOnProgress = true;

            await this.getCustomerDue();

            let url = "/add_sales";
            if (this.sales.salesId != 0) {
                url = "/update_sales";
                this.sales.previousDue = parseFloat((this.sales.previousDue - this.sales_due_on_update))
                    .toFixed(2);
            }

            if (parseFloat(this.selectedCustomer.Customer_Credit_Limit) < (parseFloat(this.sales.due) +
                    parseFloat(this.sales.previousDue))) {
                alert(`Customer credit limit (${this.selectedCustomer.Customer_Credit_Limit}) exceeded`);
                this.saleOnProgress = false;
                return;
            }

            if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != null) {
                this.sales.employeeId = this.selectedEmployee.Employee_SlNo;
            } else {
                this.sales.employeeId = null;
            }

            this.sales.customerId = this.selectedCustomer.Customer_SlNo;
            this.sales.salesFrom = this.selectedBranch.brunch_id;

            let data = {
                sales: this.sales,
                cart: this.cart
            }

            if (this.selectedCustomer.Customer_Type == 'G') {
                data.customer = this.selectedCustomer;
            }
            axios.post(url, data).then(async res => {
                let r = res.data;
                if (r.success) {
                    let conf = confirm('Sale success, Do you want to view invoice?');
                    if (conf) {
                        window.open('/sale_invoice_print/' + r.salesId, '_blank');
                        await new Promise(r => setTimeout(r, 1000));
                        window.location = this.sales.isService == 'false' ? '/sales/product' :
                            '/sales/service';
                    } else {
                        window.location = this.sales.isService == 'false' ? '/sales/product' :
                            '/sales/service';
                    }
                } else {
                    alert(r.message);
                    this.saleOnProgress = false;
                }
            })
        },
        async getSales() {
            await axios.post('/get_sales', {
                salesId: this.sales.salesId
            }).then(res => {
                let r = res.data;
                let sales = r.sales[0];
                this.sales.salesBy = sales.AddBy;
                this.sales.salesFrom = sales.SaleMaster_branchid;
                this.sales.salesDate = sales.SaleMaster_SaleDate;
                this.sales.salesType = sales.SaleMaster_SaleType;
                this.sales.customerId = sales.SalseCustomer_IDNo;
                this.sales.employeeId = sales.Employee_SlNo;
                this.sales.subTotal = sales.SaleMaster_SubTotalAmount;
                this.sales.discount = sales.SaleMaster_TotalDiscountAmount;
                this.sales.vat = sales.SaleMaster_TaxAmount;
                this.sales.transportCost = sales.SaleMaster_Freight;
                this.sales.total = sales.SaleMaster_TotalSaleAmount;
                this.sales.paid = sales.SaleMaster_PaidAmount;
                this.sales.previousDue = sales.SaleMaster_Previous_Due;
                this.sales.due = sales.SaleMaster_DueAmount;
                this.sales.note = sales.SaleMaster_Description;
                this.sales.payment_type = sales.payment_type;
                this.selectedAccount = this.accounts.find(item => item.account_id == sales
                    .account_id)

                this.oldCustomerId = sales.SalseCustomer_IDNo;
                this.oldPreviousDue = sales.SaleMaster_Previous_Due;
                this.sales_due_on_update = sales.SaleMaster_DueAmount;

                this.vatPercent = parseFloat(this.sales.vat) * 100 / parseFloat(this.sales
                    .subTotal);
                this.discountPercent = parseFloat(this.sales.discount) * 100 / parseFloat(this.sales
                    .subTotal);

                this.selectedEmployee = {
                    Employee_SlNo: sales.employee_id,
                    Employee_Name: sales.Employee_Name
                }

                this.selectedCustomer = {
                    Customer_SlNo: sales.SalseCustomer_IDNo,
                    Customer_Code: sales.Customer_Code,
                    Customer_Name: sales.Customer_Name,
                    display_name: sales.Customer_Type == 'G' ? 'General Customer' :
                        `${sales.Customer_Code} - ${sales.Customer_Name}`,
                    Customer_Mobile: sales.Customer_Mobile,
                    Customer_Address: sales.Customer_Address,
                    Customer_Type: sales.Customer_Type
                }

                r.saleDetails.forEach(product => {

                    product.serial.map(async p => {
                        return p.imeiNumber = p.ps_serial_number;
                    })

                    let cartProduct = {
                        productId: product.Product_IDNo,
                        categoryName: product.ProductCategory_Name,
                        name: product.Product_Name,
                        unitName: product.Unit_Name,
                        salesRate: product.SaleDetails_Rate,
                        vat: product.SaleDetails_Tax,
                        quantity: product.SaleDetails_TotalQuantity,
                        total: product.SaleDetails_TotalAmount,
                        purchaseRate: product.Purchase_Rate,
                        warranty: product.warranty,
                        SerialStore: product.serial
                    }

                    this.cart.push(cartProduct);
                })

                let gCustomerInd = this.customers.findIndex(c => c.Customer_Type == 'G');
                this.customers.splice(gCustomerInd, 1);
            })
        }
    }
})
</script>