<style>
.v-select {
    margin-top: -2.5px;
    float: left;
    min-width: 405px;
    margin-left: 5px;
}

.v-select .dropdown-toggle {
    padding: 0px;
    height: 25px;
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

#searchForm select {
    padding: 0;
    border-radius: 4px;
}

#searchForm .form-group {
    margin-right: 5px;
}

#searchForm * {
    font-size: 13px;
}

.mb {
    margin-bottom: 7px;
}

.button {
    background-color: green;
    border-radius: 5px;
    color: #fff;
    padding: 3px 5px;
    font-weight: 500;
    border: 1px solid transparent;
    transition: .5s;
}

.button:hover {
    background-color: #306a30;

}


.button a {
    text-decoration: none;
}
</style>
<div id="cashTransactionReport">

    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    <form action="" class="form-horizontal" @submit.prevent="saveTransaction">

                        <div class="form-group mb">
                            <label for="" class="control-label col-md-4">Branch</label>
                            <div class="col-md-8">
                                <v-select v-bind:options="branches" v-model="selectedBranch" label="Brunch_name"
                                    placeholder="Select Branch"></v-select>
                            </div>
                        </div>


                        <div class="form-group mb">
                            <label for="" class="control-label col-md-4">Service Engineer</label>
                            <div class="col-md-8">
                                <v-select v-bind:options="employees" v-model="selectedEmployee" label="display_name"
                                    placeholder="Select Engineer"></v-select>
                            </div>
                        </div>


                        <div class="form-group mb">
                            <label for="" class="control-label col-md-4">Note</label>
                            <div class="col-md-8">
                                <textarea class="form-control" v-model="note"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                                <input type="submit" value="Transfer Request" class="btn btn-success btn-xs">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <h2 class="center" style="font-weight:bold;">Transfared Service List</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="margin-top:15px;margin-bottom:15px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="printContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Service Id</th>
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                            <th>PS Number</th>
                            <th>Product Name</th>
                            <th>Request Date</th>
                            <th>Service Engineer</th>
                            <th>Service Type</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="service in service_records">
                            <td>{{service.product_service_id}}</td>
                            <td>{{service.Customer_Code}}</td>
                            <td>{{service.Customer_Name}}</td>
                            <td> {{service.ps_number}} </td>
                            <td>{{service.Product_Name}} </td>
                            <td> {{service.request_date}}</td>
                            <td> </td>
                            <td>
                                <span v-if="service.service_type == 'free'"
                                    style="font-weight:bold; color:blueviolet; font-size:15px;"> Free </span>
                                <span v-else style="font-weight:bold; color:deepskyblue; font-size:15px;"> Paid </span>
                            </td>

                            <td> {{service.note}}</td>
                            <td style="text-align:right;">
                                <span v-if="service.status == 'a'" class="text-success" style="font-weight:bold;">
                                    Approved
                                </span>

                                <span v-else>
                                    Pending
                                </span>

                            </td>
                            <td>
                                <a href="#" class="button" v-on:click="fetchRecord(service)"><i class="fa fa-pencil"
                                        style="margin-right:4px;">
                                    </i>Update</a>
                                <a href="#" class="button" v-on:click="fetchRecord(service)"><i class="fa fa-check">
                                    </i> Done </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
    el: '#cashTransactionReport',
    data() {
        return {
            accounts: [],
            selectedAccount: null,
            service_records: [],
            branch: '',
            branches: [],
            selectedEmployee: null,
            employees: [],
            services: [],

            selectedBranch: {
                brunch_id: null,
                Brunch_name: 'select Branch',
            },
            note: '',
            customer_id: '<?php echo $this->session->userdata("userId")?>',
            branch_id: '<?php echo $this->session->userdata("BRANCHid")?>',
        }
    },
    created() {
        this.serviceRecord();
        this.getEmployees();
        this.getBranch();
    },
    methods: {


        serviceRecord() {

            let filter = {
                // customerId: this.customer_id,
                branchId: this.branch_id,
                status: 'a'
            }

            axios.post('/get_transfared_service_list', filter).then(res => {
                this.service_records = res.data;

            })
        },

        saveTransaction() {

        },

        fetchRecord(service) {
            let filter = {
                serviceId: service.product_service_id
            }
            axios.post('/get_product_service_record_edit', filter).then(res => {
                this.note = res.data.note;

                this.selectedBranch = {
                    brunch_id: res.data.ps_brunchId,
                    Brunch_name: res.data.Brunch_name,
                }


            })
        },

        getEmployees() {

            axios.get('/get_employees').then(res => {
                this.employees = res.data;
            })
        },

        getBranch() {

            axios.get('/get_branches').then(res => {
                this.branches = res.data;
            })
        },
        async print() {


            let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">All Service Request</h4 style="text-align:center">
                     
                    </div>
                    <div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#printContent').innerHTML}
							</div>
						</div>
                    </div>
                `;

            let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
            printWindow.document.write(`
                    <?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
                `);

            printWindow.document.body.innerHTML += printContent;
            printWindow.focus();
            await new Promise(r => setTimeout(r, 1000));
            printWindow.print();
            await new Promise(resolve => setTimeout(resolve, 1000));
            printWindow.close();
        }
    }
})
</script>