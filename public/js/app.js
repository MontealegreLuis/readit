/**
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
(function($) {
    $('.upvote').on('click', function(e) {
        var url = '/links/upvote/{id}'.replace('{id}', $(this).data('id'));
        var $link = $(this);
        var $vote = $link.parent();
        var $downvote = $vote.find('.downvote');
        var $votes = $(this).parent().find('.votes-count');
        e.preventDefault();
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(link) {
                $votes.text(link.votes);
                $link.addClass('link-voted');
                $downvote.removeClass('link-voted');
            }
        });
    });

    $('.downvote').on('click', function(e) {
        var url = '/links/downvote/{id}'.replace('{id}', $(this).data('id'));
        var $link = $(this);
        var $vote = $link.parent();
        var $upvote = $vote.find('.upvote');
        var $votes = $vote.find('.votes-count');
        e.preventDefault();
        $.ajax({
            url: url,
            dataType: 'json',
            success: function(link) {
                $votes.text(link.votes);
                $link.addClass('link-voted');
                $upvote.removeClass('link-voted');
            }
        });
    });
})(jQuery);