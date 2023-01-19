<?php

interface NyzoTest {
    public function run(): bool;
    public function getFailureCause(): string;
}