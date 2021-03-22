<?php $this->load->view('Templates/headersidebar_view'); ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
</div>
    </div>  
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"> 
                                            <h2>Logical Network Topology</h2>
                                            <a class="btn btn-success pull-right" data-aksi="print" style="margin:10px 0 0 0px"><i class="fa fa-print"></i></a> 
                                        </div>
                                        <div class="panel-body">
                                            <div class="container-topology cols-sm-12" id="divPrint">
                                                <div id="topology-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>

<?php $this->load->view('Templates/footer_view'); ?>
<script>
    var topologyData = {"nodes": [], "links": []};
    getData();

    function getData(){
        $.ajax({
			url: '<?php echo site_url("Topology/getNodes");?>',     						
            type: "POST",
            async : false,
			dataType: "JSON",
			success: function(data) {
                // var temp = $.parseJSON(data);
                $.each(data.data.nodes, function(k,v){
                    topologyData['nodes'].push(v);
                })
                $.each(data.data.links, function(k,v){
                    topologyData['links'].push(v);

                })
                // console.log(data);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
              console.error("Status: " + textStatus + " request: " + XMLHttpRequest); 
              console.error("Error: " + errorThrown); 
			}       
		});
    }

                // console.log(topologyData);	

    (function(nx){
        nx.define('ExtendedNode', nx.graphic.Topology.Node, {
            view: function (view) {
                view.content.push({
                    // name to retrieve the object
                    "name": "deviceDownBadge",
                    // inherit from "Circle" class
                    "type": "nx.graphic.Circle",
                    "props": {
                        // radius
                        "r": 5,
                        // background color
                        "fill": "#ff0000",
                        // should be invisible by default
                        "visible": false
                    }
                });
                return view;
            },
            methods: {

                // called when the model is about to initialize
                'setModel': function (model) {
                    this.inherited(model);
                    var status = model['_data']['status'];
                    // draw/not draw the badge based on status
                    if (status == 'Connected'){
                        
                        this._hideDownBadge();
                    }else{
                        this._showDownBadge();
                    }
                },

                // display the red badge
                "_showDownBadge": function () {
                    // view of badge
                    var badge = this.view("deviceDownBadge");

                    // set properties
                    badge.sets({
                        // make visible
                        "visible": true,
                        // set X offset
                        "cx": -5,
                        // set Y offset
                        "cy": 5
                    });

                },

                // make the badge invisible
                "_hideDownBadge": function () {
                    this.view("deviceDownBadge").set("visible", false);
                }
            }
        });
    })(nx);

    (function (nx) {
	nx.define('MyTopology', nx.graphic.Topology, {
		methods: {
			"init": function(){
				this.inherited({
					// width 100% if true
					'adaptive': false,
					// show icons' nodes, otherwise display dots
					'showIcon': true,
					// special configuration for nodes
					'nodeConfig': {
						'label': 'model.name',
						'iconType': function (model, node) {
                            var platform = model['_data']['platform'];
                            // console.log(;
							if(typeof platform == "string" && platform == "MikroTik"){
                                return "rb";
                            }else if(typeof platform == "string" && platform == "CCR"){
                                return "ccr";    
                            }else if(typeof platform == "string" && platform == "UniFi"){
                                return "unifi";    
                            }else if(typeof platform == "string" && platform == "UniFi Switch"){
                                return "unifiswitch";    
                            }

						},
						'color': '#0how00'
					},
					// special configuration for links
					'linkConfig': {
						'linkType': 'curve'
					},
					// property name to identify unique nodes
					'identityKey': 'id', // helps to link source and target
					// canvas size
					'width': 1200 ,
					'height': 600,
					// "engine" that process topology prior to rendering
					'dataProcessor': 'force',
					// moves the labels in order to avoid overlay
					'enableSmartLabel': true,
					// smooth scaling. may slow down, if true
					'enableGradualScaling': true,
					// if true, two nodes can have more than one link
					'supportMultipleLink': true,
					// enable scaling
                    "scalable": true,
                    // extended node
					"nodeInstanceClass": "ExtendedNode"
				});
			}
		}
    });
    // instantiate NeXt app
	var app = new nx.ui.Application();

    // instantiate Topology class
    var topology = new MyTopology();

    topology.registerIcon("rb", "<?php echo base_url('assets/img/rb.png')?>", 30, 30);
    topology.registerIcon("ccr", "<?php echo base_url('assets/img/CCR.ico')?>", 50, 50);
    topology.registerIcon("unifi", "<?php echo base_url('assets/img/unifi.png')?>", 30, 30);
    topology.registerIcon("unifiswitch", "<?php echo base_url('assets/img/UnifiSwitch.ico')?>", 30, 30);
    // load topology data from app/data.js
    topology.data(topologyData);

    // bind the topology object to the app
    topology.attach(app);

    // app must run inside a specific container. In our case this is the one with id="topology-container"
    app.container(document.getElementById("topology-container"));
})(nx);
$('.n-topology').appendTo($('.container-topology'));
$('.n-topology').css('width','100%');
$('.n-topology svg').css('width','100%');
$('body').on('click','a[data-aksi="print"]',function(){
    // $("#divPrint").show();  
    javascript:window.print();
    // printDiv()
});

function printDiv(){
		var divToPrint=document.getElementById('divPrint');

		var newWin=window.open('','Print-Window');

		newWin.document.open();

		newWin.document.write('<html><body onload="window.print()"><h2 style="text-align:center">Statistic</h2>'+divToPrint.innerHTML+'</body></html>');

		newWin.document.close();

		setTimeout(function(){newWin.close();},10);
	}
</script>

</body>
</html>