<?php

/**
 * PaymentCoreBundle for Symfony2
 *
 * This Bundle is part of Symfony2 Payment Suite
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @package PaymentCoreBundle
 *
 * Marc Morera 2013
 */

namespace PaymentSuite\PaymentCoreBundle\Services;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;
use PaymentSuite\PaymentCoreBundle\PaymentMethodInterface;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderLoadEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderCreatedEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderDoneEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderSuccessEvent;
use PaymentSuite\PaymentCoreBundle\Event\PaymentOrderFailEvent;
use PaymentSuite\PaymentCoreBundle\PaymentCoreEvents;

/**
 * Payment event dispatcher.
 */
class PaymentEventDispatcher
{

    /**
     * @var EventDispatcherInterface
     *
     * Event dispatcher
     */
    private $eventDispatcher;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Notifies when order must be created
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Patment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderLoad(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod)
    {

        $paymentOrderLoadEvent = new PaymentOrderLoadEvent($paymentBridge, $paymentMethod);
        $this->eventDispatcher->dispatch(PaymentCoreEvents::PAYMENT_ORDER_LOAD, $paymentOrderLoadEvent);

        return $this;
    }

    /**
     * Notifies when order must be created
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Patment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderCreated(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod)
    {

        $paymentOrderCreatedEvent = new PaymentOrderCreatedEvent($paymentBridge, $paymentMethod);
        $this->eventDispatcher->dispatch(PaymentCoreEvents::PAYMENT_ORDER_CREATED, $paymentOrderCreatedEvent);

        return $this;
    }

    /**
     * Notifies when order payment process is done
     *
     * It doesn't matters if process its been success or failed
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Patment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderDone(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod)
    {
        $paymentOrderDoneEvent = new PaymentOrderDoneEvent($paymentBridge, $paymentMethod);
        $this->eventDispatcher->dispatch(PaymentCoreEvents::PAYMENT_ORDER_DONE, $paymentOrderDoneEvent);

        return $this;
    }

    /**
     * Notifies when payment process is done and succeded.
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Patment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderSuccess(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod)
    {

        $paymentOrderSuccessEvent = new PaymentOrderSuccessEvent($paymentBridge, $paymentMethod);
        $this->eventDispatcher->dispatch(PaymentCoreEvents::PAYMENT_ORDER_SUCCESS, $paymentOrderSuccessEvent);

        return $this;
    }

    /**
     * Notifies when payment is done and failed
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Patment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderFail(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod)
    {

        $paymentOrderFailEvent = new PaymentOrderFailEvent($paymentBridge, $paymentMethod);
        $this->eventDispatcher->dispatch(PaymentCoreEvents::PAYMENT_ORDER_FAIL, $paymentOrderFailEvent);

        return $this;
    }
}
