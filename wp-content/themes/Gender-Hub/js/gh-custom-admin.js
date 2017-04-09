/**
 * Created by Sarah on 07/02/2016.
 */
(function($) {

    $(document).ready(function () {

        $( ".pickadate" ).datepicker({
            dateFormat: "d MM yy"
        });

        var fields_to_hide = [
            'bridge_object_id',
            'date-created',
            'date_updated',
            'language_name',
            'metadata_url',
            'site',
            'timestamp',
            'website_url',
            'licence_type'
        ];
        $("input[type=text]").each(function() {
            if($.inArray(this.value, fields_to_hide) > -1) {
                $(this).parent().parent().css("display", "none");
            }
        });

        $("#postcustomstuff>p").css("display", "none");

        $("#postcustomstuff>#newmeta").css("display", "none");

    });

}(jQuery));

