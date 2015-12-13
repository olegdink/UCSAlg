<?php
/**
 * Author: Oleg Prolubshchikov <web@dink.ru>
 * Date, Time: 12.12.15 15:16
 *
 * Description: Uniform Cost Search (UCS) is a tree search algorithm related to breadth-first search.
 * Whereas breadth-first search determines a path to the goal state that has the least number of
 * edges, uniform cost search determines a path to the goal state that has the lowest weight.
 */

include_once("UCSQueue.php");
include_once("UCSAlgorithm.php");

$s = new UCSAlgorithm("Saint Petersburg", "Gannover",
    [
        ["from" => "Saint Petersburg", "to" => "Gannover", "cost" => 12],
        ["from" => "Saint Petersburg", "to" => "Aktobe", "cost" => 1],
        ["from" => "Aktobe", "to" => "Cansas", "cost" => 1],
        ["from" => "Cansas", "to" => "Gannover", "cost" => 2],
        ["from" => "Aktobe", "to" => "Bryansk", "cost" => 3],
        ["from" => "Bryansk", "to" => "Dublin", "cost" => 3],
        ["from" => "Cansas", "to" => "Dublin", "cost" => 1],
        ["from" => "Dublin", "to" => "Gannover", "cost" => 3],
    ]);

if ($s->Test())
{
    var_dump($s->GetCheapestPath(TRUE)); // with debug mode
}
else
{
    throw new Exception("Bad test checking");
};
