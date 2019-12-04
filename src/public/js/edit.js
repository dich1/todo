$('#add-form').click(function(){
    addForm();
});

function addForm() {
    var addFormCount = 1;
    var currentFormCount = $(".num").length;
    var maxFormCount = 100;
    if (maxFormCount - currentFormCount === 0) {
        return;
    }
    $('.commits').append(createAddElement(currentFormCount));
    setSwaps();
}

function createAddElement(currentFormCount) {
    return '<div class="commit-item-bloc">'
         + '<div class="commit-item-bloc-num">'
         + '<span class="num">' + String(currentFormCount + 1) + '</span>'
         + '<div class="">'
         + '<div class="form-group ">'
         + '<input type="hidden" name="commit-group-id[]" class="form-control" value="">'
         + '</div>'
         + '<div class="form-group ">'
         + '<input type="hidden" id="status-field-" name="status[]" class="form-control" value="0">'
         + '</div>'
         + '<div class="form-group ">'
         + '<input type="hidden" name="priority[]" class="form-control" value="' + currentFormCount + '">'
         + '</div>'
         + '<span class="completion">完了にする</span>'
         + '<span class="move-up">↑</span>'
         + '<span class="move-down">↓</span>'
         + '<span class="delete add-form">×</span>'
         + '</div>'
         + '</div>'
         + '<div class="form-group">'
         + '<input type="text" name="content[]" class="form-control" value="" required>'
         + '</div>'
         + '</div>';
}

$(document).on('click','.add-form', function(){
    $(this).parents('.commit-item-bloc').remove();
});

$(document).on('click','.completion', function(){
    changeStatus(this, 1, 'incomplete', '未完了に戻す');
});

$(document).on('click','.incomplete', function(){
    changeStatus(this, 0, 'completion', '完了にする');
});

function changeStatus(event, value, className, statusText) {
    $(event).removeClass().addClass(className);
    $(event).text(statusText);
    var index = $(event).prev().children().attr('id').split('-').pop();
    var contentId = '#content-field-' + index;
    var content = (value === 1) ? $(contentId).val() : $(contentId).children().text();
    var contentParent = $(contentId).parent();
    contentParent.empty();
    var appendText = (value === 1) 
                   ? '<p id="content-field-' + index + '" class="completion-txt"><span>' + content + '</span></p>'
                   + '<input type="hidden" name="content[]" class="form-control" value="' + content + '"/>'
                   : '<input type="text" id="content-field-' + index + '" name="content[]" class="form-control" value="' + content + '"/>';
    contentParent.append(appendText);
    var statusId = '#status-field-' + index;
    $(statusId).val(value);
}

function swapCards(card1, card2){
    var duration = 300;

    if(!card2 || !card2.classList.contains('commit-item-bloc')) return;

    var orgDuration1 = card1.style.transitionDuration;
    var orgDuration2 = card2.style.transitionDuration;

    card1.style.transitionDuration = duration + 'ms';
    card2.style.transitionDuration = duration + 'ms';

    var diff = card2.offsetTop - card1.offsetTop;

    if(diff > 0){
        var spacing = card2.offsetTop - (card1.offsetTop + card1.offsetHeight);
        card1.style.transform = "translateY(" + (card2.offsetHeight + spacing) + "px)";
        replaceNextAttribute(card1);
        card2.style.transform = "translateY(" + (-diff) + "px)";
        replacePreviousAttribute(card2);
    } else {
        var spacing = card1.offsetTop - (card2.offsetTop + card2.offsetHeight);
        card1.style.transform = "translateY(" + (diff) + "px)";
        replacePreviousAttribute(card1);
        card2.style.transform = "translateY(" + (card1.offsetHeight + spacing) + "px)";
        replaceNextAttribute(card2);
    }
    setTimeout(function(){
        card1.style.transitionDuration = orgDuration1;
        card2.style.transitionDuration = orgDuration2;
        card1.style.transform = "translateY(0)";
        card2.style.transform = "translateY(0)";

        if(diff < 0){
            card1.parentNode.insertBefore(card1, card2);
        } else {
            card1.parentNode.insertBefore(card2, card1);
        }
    }, duration);
}

function replaceNextAttribute(card) {
    var indexNumber = Number(card.querySelector('.num').innerText) - 1;
    var currentIndexString = String(indexNumber);
    var nextIndexString = String(Number(indexNumber) + 1);
    card.querySelector("input[name='priority[]']").value = nextIndexString;
    card.querySelector('.num').innerText = String(Number(card.querySelector('.num').innerText) + 1);
}

function replacePreviousAttribute(card) {
    var indexNumber = Number(card.querySelector('.num').innerText) - 1;
    var currentIndexString = String(indexNumber);
    var previousIndexString = String(Number(indexNumber) - 1);
    card.querySelector("input[name='priority[]']").value = previousIndexString;
    card.querySelector('.num').innerText = String(Number(card.querySelector('.num').innerText) - 1);
}

function setSwaps() {
    var cards = $('.commit-item-bloc');

    cards.find('.move-up').off('click');
    cards.find('.move-down').off('click');

    cards.find('.move-up').on('click', function(e){
        var card = $(this).closest('.commit-item-bloc')[0];
        swapCards(card, card.previousElementSibling);
    });
    cards.find('.move-down').on('click', function(e){
        var card = $(this).closest('.commit-item-bloc')[0];
        swapCards(card, card.nextElementSibling);
    });
}

document.addEventListener('DOMContentLoaded', function(){
    setSwaps();
});