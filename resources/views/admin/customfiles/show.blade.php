<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<title></title>
<style>
    /* Keep only print-specific and special layout styles that can't be handled by Tailwind */
    #printDiv {
        width: 100%;
        max-width: 20.8cm;
        height: 100%;
        max-height: 15cm;
        overflow: hidden;
        background-image: url(/images/bg.jpg);
        background-size: cover;
        padding-top: 4.65cm;
        padding-left: 5.7cm;
    }

    .child2 {
        text-align: right;
        padding-right: 2.5cm;
    }

    @media print {
        @page {
            size: 20.8cm 15cm portrait;
        }
        .hidden-print {
            display: none;
        }
        #printDiv {
            padding-top: 4.3cm !important;
            padding-left: 5.7cm !important;
        }
    }
</style>

<div id="invoice" class="max-w-5xl mx-auto p-6">
    <div class="toolbar hidden-print">
        <div class="text-right space-x-2 mb-4">
            <button onclick="printDiv()" id="printInvoice" class="px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 text-white rounded-md shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                <i class="fa fa-print"></i> Print
            </button>
            <a href="/file_datas" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition-colors">Back</a>
        </div>
        <hr class="border-gray-200">
    </div>

    <div id="printDiv">
        <main>
            <div class="w-full mb-4 text-lg font-bold h-12">
                <div class="w-[49%] inline-block">
                    {{$file_data->lodgement_no}}
                </div>
                <div class="w-[49%] inline-block child2">
                    {{$file_data->lodgement_date}}
                </div>
            </div>

            <div class="w-full mb-4 text-lg font-bold h-12">
                <div class="w-full">
                    {{$file_data->agent->name}}
                </div>
            </div>

            <div class="w-full mb-4 text-lg font-bold h-12">
                <div class="w-[49%] inline-block">
                    {{$file_data->be_number}}
                </div>
                <div class="w-[49%] inline-block child2">
                    {{$file_data->manifest_date}}
                </div>
            </div>
        </main>
        <div></div>
    </div>
</div>

<script>
    function printDiv() {
        window.print();
        return true;
    }

    $(document).ready(function () {
        window.print();
        setTimeout(function() {
            window.location.href = "{{ URL::previous() }}";
        }, 100);
    });
</script>

