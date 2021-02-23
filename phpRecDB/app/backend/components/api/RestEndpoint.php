<?php


abstract class RestEndpoint
{

    public function list() : array {
        throw new BadMethodCallException();
    }

    public function view() : array {
        throw new BadMethodCallException();
    }

    public function update() : array {
        throw new BadMethodCallException();
    }

    public function create() : array {
        throw new BadMethodCallException();
    }

    public function delete() : array {
        throw new BadMethodCallException();
    }

    public abstract function getName(): string;

}