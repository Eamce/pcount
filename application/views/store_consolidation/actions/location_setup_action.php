<script type="text/javascript">
    function loadTable(stat){
        tbl_location = $('#location_tbl').DataTable({
            destroy:true,
            'ajax':'<?php echo base_url('setup/get_location/?stat=')?>'+stat,
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    }
    loadTable("Active");
    
    function addLocationModal(){
        $('form#addLocation select, input').val("");
        $('[name="bunit"]').html('<option value="" disabled selected>Select</option>');
        $("#myModal4 h4.modal-title").html("New Location and User");
        $(".form-action").removeAttr("id").attr("id","addLocation");
        $(".search-results-header, .search-results-header1").hide();
        $("[name='cid'], [name='cid1']").val("");
        $("[name='name'], [name='name1']").val("");
        $("[name='eno'],[name='eno1']").val("");
        $("[name='epins'],[name='epins1']").val("");
        $("[name='epos'],[name='epos1']").val("");
        $("#asLocation").html("");
        $("#btn-add-location").attr("disabled",false);
        $.ajax({
            url: "<?php echo base_url('setup/get_company')?>",
            dataType:'json',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                var mhtml="";
				mhtml += '<option value="" disabled selected>Select</option>';
				$.each(data.data, function(index, element){
					mhtml += "<option value='"+element.loccode+"/"+element.locname+"'>"+element.locname+"</option>";					
				});
				$('[name="company"]').html(mhtml);
                $('[name="dept"]').html('<option value="" disabled selected>Select</option>');
                $('[name="section"]').html('<option value="" disabled selected>Select</option>');
            }
        });
        $("#myModal4").modal("show");
        $("[name='search-employee']").keyup(function(){
            
            $(".search-results-header").show();
            var str = this.value.trim();
            $(".search-results-header").hide();
            if(str == '') {
                $(".search-results-header").slideUp(100);
            }
            else {
                $.ajax({	
                    type : "POST",
                    url  : '<?= base_url()?>'+'setup/search_employee',
                    data : { str : str},
                    dataType: 'json',
                    success : function(data){
                        var mhtml = "";
                        $.each(data.data, function(index, element){
                            mhtml += '<a href="javascript:void(0)" onclick=\'addSearch("'+element.cid+'","'+element.fname+'","'+element.eno+'","'+element.epins+'","'+element.epos+'")\'>'+element.fname+'</a></br>';
                        });
                        // if(data){
                            $(".search-results-header").show().html(mhtml); 
                        // }
                    }
                });
            }
        });
        $("[name='search-employee1']").keyup(function(){
            
            $(".search-results-header1").show();
            var str = this.value.trim();
            $(".search-results-header1").hide();
            if(str == '') {
                $(".search-results-header1").slideUp(100);
            }
            else {
                $.ajax({	
                    type : "POST",
                    url  : '<?= base_url()?>'+'setup/search_employee',
                    data : { str : str},
                    dataType: 'json',
                    success : function(data){
                        var mhtml = "";
                        $.each(data.data, function(index, element){
                            mhtml += '<a href="javascript:void(0)" onclick=\'addSearch1("'+element.cid+'","'+element.fname+'","'+element.eno+'","'+element.epins+'","'+element.epos+'")\'>'+element.fname+'</a></br>';
                        });
                        // if(data){
                            $(".search-results-header1").show().html(mhtml); 
                        // }
                    }
                });
            }
        });
    }
    function addSearch(id,name,eno,epins,epos){
        $("[name='search-employee']").val(name).focus();
        $(".search-results-header").hide();
        $("[name='cid']").val(id);
        $("[name='name']").val(name);
        $("[name='eno']").val(eno);
        $("[name='epins']").val(epins);
        $("[name='epos']").val(epos);
    }
    function addSearch1(id,name,eno,epins,epos){
        var name1   = $("[name='search-employee']").val();
        if(name == name1){
            Command: toastr['error']("Employee already set to user.");
            $("[name='search-employee1']").val("").focus();
            $("[name='cid1']").val("");
            $("[name='name1']").val("");
            $("[name='eno1']").val("");
            $("[name='epins1']").val("");
            $("[name='epos1']").val("");
        }else{
            $("[name='search-employee1']").val(name).focus();
            $(".search-results-header1").hide();
            $("[name='cid1']").val(id);
            $("[name='name1']").val(name);
            $("[name='eno1']").val(eno);
            $("[name='epins1']").val(epins);
            $("[name='epos1']").val(epos);
        }        
    }
    function getBunit(cid){
        if(cid){
            $.ajax({
                url: "<?php echo base_url('setup/get_bunit')?>",
                type:"POST",
                data: {cid:cid},
                dataType:'json',
                success:function(data){
                    var mhtml="";
                    mhtml += '<option value="" disabled selected>Select</option>';
                    $.each(data.data, function(index, element){
                        mhtml += "<option value='"+element.bcode+"/"+element.ccode+"/"+element.bname+"'>"+element.bname+"</option>";					
                    });
                    $('[name="bunit"]').html(mhtml);
                    $('[name="section"]').html('<option value="" disabled selected>Select</option>');
                }
            });
        }        
    }
    function getDept(bid){
        if(bid){
            $.ajax({
                url: "<?php echo base_url('setup/get_dept')?>",
                type:"POST",
                data: {bid:bid},
                dataType:'json',
                success:function(data){
                    var mhtml="";
                    mhtml += '<option value="" disabled selected>Select</option>';
                    $.each(data.data, function(index, element){
                        mhtml += "<option value='"+element.dcode+"/"+element.bcode+"/"+element.ccode+"/"+element.dname+"'>"+element.dname+"</option>";					
                    });
                    $('[name="dept"]').html(mhtml);
                }
            });
        }
    }
    function getSection(did){
        if(did){
            $.ajax({
                url: "<?php echo base_url('setup/get_section')?>",
                type:"POST",
                data: {did:did},
                dataType:'json',
                success:function(data){
                    var mhtml="";
                    mhtml += '<option value="" disabled selected>Select</option>';
                    $.each(data.data, function(index, element){
                        mhtml += "<option value='"+element.scode+"/"+element.dcode+"/"+element.bcode+"/"+element.ccode+"/"+element.sname+"'>"+element.sname+"</option>";					
                    });
                    $('[name="section"]').html(mhtml);
                }
            });
        }
    }
    $('form').submit(function(e){
        e.preventDefault();
        var toPath  = $(this).attr('id');
        var res = "";
        if(toPath == "addLocation"){
            res = "save_location";
        }else{
            res = "update_location";
        }
        var formData = new FormData(this);
        $.ajax({
            url:'setup/'+res,
            method:'POST',
            data:formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success:function(msg){
                var json = $.parseJSON(msg);
                if(json.status == "success"){
                    Command: toastr['success'](json.msg);
                    $('#myModal4').modal('hide');
                    tbl_location.ajax.reload(null, false);
                }else{
                    Command: toastr['error'](json.msg);
                }
            }
        });
    });
    $('.formAction').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var toPath  = $(this).attr('id');
        var res = "";
        if(toPath == "delLocation"){
            res = "del_location";
        }else if(toPath == "deactLocation"){
            res = "deact_location";
        }else{
            res = "act_location";
        }
        $.ajax({
            url:'setup/'+res,
            method:'POST',
            data:formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success:function(msg){
                var json = $.parseJSON(msg);
                if(json.status == "success"){
                    Command: toastr['success'](json.msg);
                    $('#myModal3').modal('hide');
                    tbl_location.ajax.reload(null, false);
                }else{
                    Command: toastr['error'](json.msg);
                }
            }
        });
    });
    function delLocation(id){
        $("[name='loc_id']").val(id);
        $("#myModal3").modal("show");
        $("#confirm-message").text('Are you sure you want to delete this setup?');
        $(".formAction").removeAttr("id").attr("id","delLocation");
    }
    function editLocation(id,codes){
        addLocationModal();
        $("#btn-add-location").attr("disabled",true);
        $("#myModal4 h4.modal-title").html("Edit Location");
        $(".form-action").removeAttr("id").attr("id","updateLocation");
        var lcode = codes.split(".");        
        $("[name='company']").val(lcode[0]+"/"+$("span[id='"+id+"_company']").html());
        getBunit(lcode[0]+"/"+$("span[id='"+id+"_company']").html());
        setTimeout(function(){
            $("[name='bunit']").val(lcode[1]+"/"+lcode[0]+"/"+$("span[id='"+id+"_bunit']").html());
        },500);
        if(lcode[1]){
            getDept(lcode[1]+"/"+lcode[0]+"/"+$("span[id='"+id+"_bunit']").html());
            setTimeout(function(){
                $("[name='dept']").val(lcode[2]+"/"+lcode[1]+"/"+lcode[0]+"/"+$("span[id='"+id+"_dept']").text());
            },600);
        }
        if(lcode[2]){
            getSection(lcode[2]+"/"+lcode[1]+"/"+lcode[0]+"/"+$("span[id='"+id+"_dept']").text());
            setTimeout(function(){
                $("[name='section']").val(lcode[3]+"/"+lcode[2]+"/"+lcode[1]+"/"+lcode[0]+"/"+$("span[id='"+id+"_section']").text());
            },700);
        }
        setTimeout(function(){
            getEmployeeInfo(id,"user");
            getEmployeeInfo(id,"audit");
        },1000);
        $("[name='rack_desc']").val($("span[id='"+id+"_desc']").text());
        $("[name='loc_id']").val(id);
        $("#asLocation").html("");
    }
    function getEmployeeInfo(id,utype){
        if(id){
            $.ajax({
                url: "<?php echo base_url('setup/get_emp_info')?>",
                type:"POST",
                data: {"locid":id,utype:utype},
                dataType:'json',
                success:function(data){
                    $.each(data.data, function(index, element){
                        if(utype=="user"){
                            $("[name='search-employee']").val(element.fname);
                            $("[name='cid']").val(element.cid);
                            $("[name='name']").val(element.fname);
                            $("[name='eno']").val(element.eno);
                            $("[name='epins']").val(element.epins);
                            $("[name='epos']").val(element.epos);
                        }else{
                            $("[name='search-employee1']").val(element.fname);
                            $("[name='cid1']").val(element.cid);
                            $("[name='name1']").val(element.fname);
                            $("[name='eno1']").val(element.eno);
                            $("[name='epins1']").val(element.epins);
                            $("[name='epos1']").val(element.epos);
                        }
                    });
                }
            });
        }
    }
    function deactLocation(id){
        $("[name='loc_id']").val(id);
        $("#myModal3").modal("show");
        $("#confirm-message").text('Are you sure you want to deactivate this setup?');
        $(".formAction").removeAttr("id").attr("id","deactLocation");
    }
    function actLocation(id){
        $("[name='loc_id']").val(id);
        $("#myModal3").modal("show");
        $("#confirm-message").text('Are you sure you want to activate this setup?');
        $(".formAction").removeAttr("id").attr("id","actLocation");
    }
    function assignLocation(){
        var toAssign = $("[name='rack_desc']").val();
        if(toAssign){
            if($('#asLocation tr > td:contains('+toAssign+')').length == 0){
                $("#asLocation").append(
                    "<tr id='rLoc_"+toAssign+"'>"+
                        "<td><input type='hidden' name='loc_details[]' value='"+toAssign+"'><span id='locName_"+toAssign+"'>"+toAssign+"</span></td>"+
                        "<td><i onclick=removeLocation('"+toAssign+"') class='fa fa-trash text-danger'></i></td>"+
                    "</tr>"
                );
                $("[name='rack_desc']").val("");
            }else{
                Command: toastr['error']("Location Description is aleady on the list.");
            }           
        } else{
            Command: toastr['error']("Please input a location Description");
            $("[name='rack_desc']").focus();
        }      
    }
    function removeLocation(str){
        $("table tr[id='rLoc_"+str+"']").remove();
    }
</script>