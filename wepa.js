import { useState } from "react";
import styled from "styled-components";
import { Row, Col } from "antd";
import { withTranslation, TFunction } from "react-i18next";
import { Slide } from "react-awesome-reveal";
import { Button } from "../../common/Button";
import { MiddleBlockSection, Content, ContentWrapper } from "./styles";
import { ContactProps, ValidationTypeProps } from "../../components/ContactForm/types";
import { useForm } from "../../common/utils/useForm";
import validate from "../../common/utils/validationRules";
import { ContactContainer, FormGroup, Span, ButtonContainer } from "../../components/ContactForm/styles";
import TextArea from "../../common/TextArea";
import Block from "../Block";

// Modal Styled Components
const ModalOverlay = styled.div`
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999; /* Ensure it is on top */
`;

const ModalContainer = styled.div`
  background-color: #fff;
  padding: 20px;
  width: 500px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  position: relative; /* To position the close button */
`;

const Title = styled.h1`
  text-align: center;
  margin-bottom: 10px;
`;

const Subtitle = styled.h3`
  text-align: center;
  color: #666;
  margin-bottom: 20px;
`;

const Input = styled.input`
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
`;

const SubmitButton = styled.button`
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #6200ea;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;

  &:hover {
    background-color: #3700b3;
  }
`;

const CloseButton = styled.button`
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;

  &:hover {
    color: red;
  }
`;

const Contact = ({ title, content, id, t }: ContactProps) => {
  const { values, errors, handleChange, handleSubmit } = useForm(validate);

  const ValidationType = ({ type }: ValidationTypeProps) => {
    const ErrorMessage = errors[type as keyof typeof errors];
    return <Span>{ErrorMessage}</Span>;
  };

// MiddleBlock Component
interface MiddleBlockProps {
  title: string;
  content: string;
  button: string;
  t: TFunction;
}

const MiddleBlock = ({ title, content, button, t }: MiddleBlockProps) => {
  const [isOpen, setIsOpen] = useState(false);

  const openModal = () => setIsOpen(true);
  const closeModal = () => setIsOpen(false);

  const scrollTo = (id: string) => {
    const element = document.getElementById(id) as HTMLDivElement;
    element.scrollIntoView({
      behavior: "smooth",
    });
  };

  return (
    <MiddleBlockSection>
      <Slide direction="up" triggerOnce>
        <Row justify="center" align="middle">
          <ContentWrapper>
            <Col lg={24} md={24} sm={24} xs={24}>
              <h6>{t(title)}</h6>
              <Content>{t(content)}</Content>
              {button && (
                <Button name="submit" onClick={openModal}>
                  {t(button)}
                </Button>
              )}
            </Col>
          </ContentWrapper>
        </Row>
      </Slide>

      {/* Modal */}
      {isOpen && (
        <ModalOverlay>
          <ModalContainer>
            <ContactContainer id={id}>
              <Row justify="space-between" align="middle">
                <Col lg={12} md={11} sm={24} xs={24}>
                  <Slide direction="left" triggerOnce>
                    <Block title={title} content={content} />
                  </Slide>
                </Col>
                <Col lg={12} md={12} sm={24} xs={24}>
                  <Slide direction="right" triggerOnce>
                    <FormGroup autoComplete="off" onSubmit={handleSubmit}>
                      <Col span={24}>
                        <Input
                          type="text"
                          name="Nombre"
                          placeholder="Tu nombre"
                          value={values.name || ""}
                          onChange={handleChange}
                        />
                        <ValidationType type="name" />
                      </Col>
                      <Col span={24}>
                        <Input
                          type="text"
                          name="Correo electronico"
                          placeholder="Tu correo electronico"
                          value={values.email || ""}
                          onChange={handleChange}
                        />
                        <ValidationType type="email" />
                      </Col>
                      <Col span={24}>
                        <TextArea
                          placeholder="Tu mensaje"
                          value={values.message || ""}
                          name="mensaje"
                          onChange={handleChange}
                        />
                        <ValidationType type="message" />
                      </Col>
                      <ButtonContainer>
                        <Button name="submit">{t("Enviar")}</Button>
                      </ButtonContainer>
                    </FormGroup>
                  </Slide>
                </Col>
              </Row>
            </ContactContainer>
          </ModalContainer>
        </ModalOverlay>
      )}
    </MiddleBlockSection>
  );
};

export default withTranslation()(MiddleBlock);
