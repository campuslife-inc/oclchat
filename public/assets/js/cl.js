
// prevent modal close by side click
$(document).ready(function(){ 
$('.modal').modal({
           show: false,
        backdrop: 'static'
    });
$('.assignment_img').addClass('img-fluid');
// side menu active class

 var url = window.location; 
        var element = $('ul.side-menu a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0; }).parent().addClass('active');
        if (element.is('li')) { 
             element.addClass('active').parent().parent('li').addClass('active')
         }

         // 
         $(".tag-img").click(function () {
        $(".tagging_div").toggle();
    });

});


$(document).on('click', '.toggle-this', function(event) {
  event.stopPropagation();
  var $this = $(this);
  var parent = $this.data('parent');
  var actives = $('#' + parent).find('[aria-expanded="true"]');
  if (actives && actives.length) {
    hasData = actives.data('collapse');
    actives.collapse('hide');
  }
  var target = $this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''); //strip for ie7
  $(target).collapse('toggle');
}); 


// hide show 
function hideNshowtwo() {
  var x = document.getElementById("tt-left");
  
  if (x.style.display === "none") {
    x.style.display = "block";
    $("#tt-left").addClass("col-md-4").removeClass("col-2");
    $("#tt-right").addClass("col-md-8").removeClass("col-md-12");
     $("#hide-img").css('transform', 'rotate(-90deg)');
     $(".hide-img").css('transform', 'rotate(-90deg)');

  } else {
    x.style.display = "none";
    $("#tt-left").addClass("col-2").removeClass("col-md-4");
    $("#tt-right").addClass("col-md-12").removeClass("col-md-8");
    $("#hide-img").css('transform', 'rotate(90deg)');
    $(".hide-img").css('transform', 'rotate(90deg)');
  }
  // activitytable.columns.adjust().draw();
}

// timetable hideNshow
function hideNshow() {
  var x = document.getElementById("tt-left");
  
  if (x.style.display === "none") {
    x.style.display = "block";
    $("#tt-left").addClass("col-3").removeClass("col-2");
    $("#tt-right").addClass("col-9").removeClass("col-12");
     $("#hide-img").css('transform', 'rotate(-90deg)');

  } else {
    x.style.display = "none";
    $("#tt-left").addClass("col-3").removeClass("col-2");
    $("#tt-right").addClass("col-12").removeClass("col-9");
    $("#hide-img").css('transform', 'rotate(90deg)');
  }
}

function hideOtherTab(id){
  $('.tab-pane :not(#collapse-'+id+')').removeClass('show');
}




// left{LHS} hide/ show
  $(document).ready(function() {
    var pathname = window.location.pathname; 
    if($(window).width() < 767){
      if( pathname.endsWith("/digitalfiles"))
      {
      }
      else
      {
        $('.question-lhs .nav-link').click(function() {
          $(this).parent().parent().parent().hide();
          $('.gotolist').show();
          $('.tab-pane').addClass('display','block');
          $('.tab-pane').addClass('active'); 
          return false;
        }); 
      }
      $('.gotolist').click(function() {
        $('.lhs-wrapper').show();
        $('.gotolist').hide();
        $('.tab-pane').addClass('display','none');
        $('.tab-pane').removeClass('active'); 
        return false;
      }); 
    }
  }); 

// activity accordian remove show class in mobile
  $(window).bind('resize load', function() {
    if ($(this).width() < 767) {
        $('#activity-accordian .collapse').removeClass('show');
        $('#activity-accordian .collapse').addClass('');
        $('#activity-accordian .card-title').removeClass('');
        $('#activity-accordian .card-title').addClass('collapsed');
    } else {
        $('#activity-accordian .collapse').removeClass('');
        $('#activity-accordian .collapse').addClass('show');
         $('#activity-accordian .card-title').removeClass('collapsed');
        $('#activity-accordian .card-title').addClass('');
    }
});

  