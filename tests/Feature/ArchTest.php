<?php

it('finds missing debug statements', function () {
    // Act & Assert
    expect(['dd', 'dump', 'ray'])
        ->not()
        ->toBeUsed();
});
