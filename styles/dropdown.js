$(document).ready(function(){
    $('#faq-questions').on('change', function(){
        var theVal = $(this).val();
        $('.answer').addClass('hidden');
        $('.answer#answer' + theVal).removeClass('hidden');
    });
});