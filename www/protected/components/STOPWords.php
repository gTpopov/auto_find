<?php
/**
 * Created by PhpStorm.
 * User: Алекс
 * Date: 25.05.14
 * Time: 22:59
 */

class STOPWords extends CApplicationComponent {

    public function listWords() {

        return
        $stopWords = array(
            'что', 'как', 'все', 'она', 'так', 'его', 'только', 'мне', 'было', 'вот',
            'меня', 'еще', 'нет', 'ему', 'теперь', 'когда', 'даже', 'вдруг', 'если',
            'уже', 'или', 'быть', 'был', 'него', 'вас', 'нибудь', 'опять', 'вам', 'ведь',
            'там', 'потом', 'себя', 'может', 'они', 'тут', 'где', 'есть', 'надо', 'ней',
            'для', 'тебя', 'чем', 'была', 'сам', 'чтоб', 'без', 'будто', 'чего', 'раз',
            'тоже', 'себе', 'под', 'будет', 'тогда', 'кто', 'этот', 'того', 'потому',
            'этого', 'какой', 'ним', 'этом', 'один', 'почти', 'мой', 'тем', 'чтобы',
            'нее', 'были', 'куда', 'зачем', 'всех', 'можно', 'при', 'два', 'другой',
            'хоть', 'после', 'над', 'больше', 'тот', 'через', 'эти', 'нас', 'про', 'них',
            'какая', 'много', 'разве', 'три', 'эту', 'моя', 'свою', 'этой', 'перед',
            'чуть', 'том', 'такой', 'более', 'всю', 'на', 'сказать', 'а', 'ж', 'со', 'же','совсем','жизнь','нельзя','за',
            'ни','здесь','бы','и','никогда','из','из-за','то','ничего','им','но','иногда','ну','в','их','о','к','об','кажется',
            'он','во','ты','у','впрочем','конечно','от','уж','которого','всегда','которые','по','хорошо','всего','ли','человек',
            'вы','лучше','г','между','говорил','да','с','до','свое','этой','мы','ее','ей','сегодня','я','наконец','сейчас',
            'сказал','не','сказала'
        );
    }

}
