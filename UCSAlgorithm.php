<?php
/**
 * Author: Oleg Prolubshchikov <web@dink.ru>
 * Date, Time: 12.12.15 15:16
 */

class UCSAlgorithm
{
    private $start;
    private $finish;
    private $list;

    private $priorityQueue;
    private $cheapestPath = [];

    function __construct($start = "", $finish = "", $list = [])
    {
        $this->start  = $start;
        $this->finish = $finish;
        $this->list   = $list;

        // -- UCS init (insert start node)
        $this->priorityQueue = new UCSQueue();
        $this->priorityQueue->insert([[$this->start],0]);
    }

    /* +------------------------------+
       | Main loop                    |
     * +------------------------------+ */
    public function GetCheapestPath($debug = FALSE)
    {
        $time_start = microtime(true);
        $memory_start = memory_get_usage();

        while ($this->priorityQueue->valid())
        {
            $this->Round();
        };

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        $memory_finish = memory_get_usage();
        $memory = $memory_finish - $memory_start;

        if ($debug) array_push($this->cheapestPath, ["Timing" => $time, "Memory" => $memory]);

        return $this->cheapestPath;
    }

    /* +------------------------------+
       | Get All Neighbors of Node    |
     * +------------------------------+ */
    private function GetNeighbors($host = "")
    {
        $res = [];
        foreach($this->list as $v)
        {
            if ($v["from"] == $host)
            {
                array_push($res, $v["to"]);
            };
        }
        return $res;
    }

    /* +------------------------------------+
       | Calculate Cost of Path throw Nodes |
     * +------------------------------------+ */
    private function GetCostPath($path=[])
    {
        $res = 0;
        for ($i=0; $i < count($path)-1; $i++)
        {
            $res = $res + $this->GetCostByNames($path[$i],$path[$i+1]);
        };
        return $res;
    }

    /* +------------------------------------+
       | General UCS iteration              |
     * +------------------------------------+ */
    private function Round()
    {
        $node = array_values($this->priorityQueue->extract())[0];

        if (end($node)==$this->finish)
        {
            $this->cheapestPath = [$node, $this->GetCostPath($node)];
            $this->priorityQueue = new UCSQueue();
        }
        else
        {
            $neighborsForNode = $this->GetNeighbors(end($node));

            // children to insert to queue for next round

            foreach($neighborsForNode as $v)
            {
                $childNode = $node;
                array_push($childNode, $v);

                $this->priorityQueue->insert([$childNode, $this->GetCostPath($childNode)]);
            };
        };
    }

    /* +------------------------------------------------+
       | Get Cost from data list between two neighbors  |
     * +------------------------------------------------+ */
    private function GetCostByNames($from, $to)
    {
        $res = 99999999999; // infinity
        foreach($this->list as $v)
        {
            if ($v["from"] == $from & $v["to"] == $to)
            {
                $res = $v["cost"];
            };
        }
        return $res;
    }

    /* +-----------------+
       | Blank for test  |
     * +-----------------+ */
    public function Test()
    {
        $res = TRUE;
        // -- Construct
        if (is_string($this->start)==TRUE &
            is_string($this->finish)==TRUE &
            is_array($this->list)==TRUE)
        {
            //echo "[OK] __construct\r\n";
            $res = TRUE;
        }
        else
        {
            //echo "[FAIL] __construct\r\n";
            $res = FALSE;
        };
        return $res;
    }
}