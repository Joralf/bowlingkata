<?php

namespace spec\JOR;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use JOR\Roll;

class FrameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JOR\Frame');
    }

    function it_has_no_rolls_when_emtpy()
    {
        $this->getFirstRoll()->shouldReturn(null);
        $this->getSecondRoll()->shouldReturn(null);
    }

    function it_accepts_a_roll()
    {
        $roll = new Roll(1);
        $this->addRoll($roll);
        $this->getFirstRoll()->shouldReturn($roll);
    }

    function it_accepts_a_second_roll()
    {
        $this->addRoll(new Roll(1));

        $roll = new Roll(4);
        $this->addRoll($roll);
        $this->getSecondRoll()->shouldReturn($roll);
    }

    function it_does_not_accept_too_many_rolls()
    {
        $this->addRoll(new Roll(1));
        $this->addRoll(new Roll(4));

        $roll = new Roll(6);
        $this->shouldThrow('JOR\TooManyRolls')->duringAddRoll($roll);
    }

    function it_does_not_accept_another_roll_after_strike()
    {
        $this->addRoll(new Roll(10));

        $roll = new Roll(5);
        $this->shouldThrow('JOR\TooManyPins')->duringAddRoll($roll);
    }

    function it_does_not_accept_more_than_ten_total_pins()
    {
        $this->addRoll(new Roll(6));

        $roll = new Roll(5);
        $this->shouldThrow('JOR\TooManyPins')->duringAddRoll($roll);
    }
}
